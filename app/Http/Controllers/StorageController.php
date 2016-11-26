<?php

namespace App\Http\Controllers;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;

class StorageController extends APIController
{
    /**
     * @var StorageClient
     */
    private $storage;

    /**
     * @var Bucket
     */
    private $bucket;

    /**
     * StorageController constructor.
     */
    public function __construct()
    {
        $this->storage = new StorageClient([
            'projectId' => config('gsc.projectId'),
            'keyFilePath' => base_path(config('gsc.auth_filename'))
        ]);

        $this->bucket = $this->storage->bucket(config('gsc.bucket'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function info() {
        if (!request('name')) return $this->error('invalid object name.');
        $object = $this->bucket->object(request('name'));
        if ($object->exists()) {
            return $this->response($object->info());
        }

        return $this->error('not exists file');
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function upload(Request $request) {
        if (!$request->has('data')) return $this->error('not given data');
        if (!$request->has('name')) return $this->error('not given name');

        $data = $request->get('data');
        $opts = ['name' => $request->get('name'), 'predefinedAcl' => 'publicRead'];

        if (strstr($data, 'base64')) {
            if (preg_match('/data\:([^\;]*)/', $data, $mimeType)) {
                $opts['contentType'] = $mimeType[1];
            }

            $exp = explode(',', $data);
            if (count($exp) === 2) {
                $data = trim($data[1]);
            } else {
                $data = str_replace('base64', '', $data);
            }
        }

        $upload = $this->bucket->upload($data, $opts);
        if ($upload) {
            return $this->response($upload->info());
        }

        return $this->error('upload not completed.');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete() {
        if (!request('name')) return $this->error('invalid object name');
        $object = $this->bucket->object(request('name'));
        if ($object->exists()) {
            $object->delete();
            return $this->response(true);
        }

        return $this->error('not exists file');
    }

    /**
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function url() {
        if (!request('name')) return $this->error('invalid object name.');
        $object = $this->bucket->object(request('name'));
        if ($object->exists()) {
            $info = $object->info();
            return $this->response('https://storage.googleapis.com/' . $info['bucket'] . '/' . $info['name']);
        }

        return $this->error('not exists file');
    }
}
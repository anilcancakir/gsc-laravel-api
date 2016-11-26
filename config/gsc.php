<?php
/*
 * Created by Anılcan ÇAKIR from Kodizm.
 * This code can't change.
 *
 * Kodizm - www.kodizm.com
 * Internet and Software solutions.
 *
 * Website: http://kodizm.com
 * E-Mail: anilcan@kodizm.com
 * 
 * Project: gsc-laravel-api
 * File: gsc.php
 * 
 * File date: 26.11.2016
 * File time: 21:31
 */

return [
    /**
     * Your project name
     */
    'projectId' => env('GSC_PROJECT_ID'),

    /**
     * Your auth file from base path
     */
    'auth_filename' => env('GSC_FILE_NAME', 'auth.json'),

    /**
     * Bucket id for storage
     */
    'bucket' => env('GSC_BUCKET_ID')
];
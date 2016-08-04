<?php

namespace App\Services;

use Formandsystem\Api\Api;
use Formandsystem\Api\Cache\LaravelCache;
use Illuminate\Http\Request;


abstract class AbstractApiService
{
    public function api($user_config = [])
    {
        // merge config
        $config = array_merge([
            'url'           => env('FS_API_URL'),
            'version'       => '1',
            'client_id'     => env('FS_API_CLIENT_ID'),
            'client_secret' => env('FS_API_CLIENT_SECRET'),
            'cache'         => true
        ], $user_config);
        // return API instance
        return (new Api($config, new LaravelCache));
    }
}

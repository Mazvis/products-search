<?php

namespace Mazvis\ProductsParser\Configs;

use Guzzle\Http\Client;
use Mazvis\ProductsParser\Services\Downloader;

class DownloaderConfig
{
    /**
     * @return Downloader
     */
    public static function getDownloaderInstance()
    {
        $client = new Client();

        $downloader = new Downloader();
        $downloader->setClient($client);

        return $downloader;
    }
}

<?php

namespace Mazvis\ProductsParser\Services;

use Guzzle\Http\Client;

class Downloader
{
    /** @var  Client */
    protected $client;

    /**
     * @param string $link
     * @return bool|string
     */
    public function getContent($link)
    {
        $response = null;

        try {
            $request = $this->client->get($link);
            $response = $request->send();
        } catch (\Exception $e) {
        }

        if ($response && $response->getStatusCode() == 200) {
            return (string) $response->getBody();
        }

        return false;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }
}

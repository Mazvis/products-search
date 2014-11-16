<?php

use Guzzle\Http\EntityBody;
use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Tests\Http\Server;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Client;
use Mazvis\ProductsParser\Services\Downloader;

class DownloaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param string $fixture
     *
     * @return string
     */
    public function getFixturePath($fixture)
    {
        $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures';
        return $path . DIRECTORY_SEPARATOR . $fixture;
    }

    public function getDownloader($fixture, $mock = true)
    {
        $downloader = new Downloader();
        if ($mock) {
            $mockResponse = new Response(200);
        } else {
            $mockResponse = new Response(255);
        }

        $mockResponseBody = EntityBody::factory(
            fopen($this->getFixturePath($fixture), 'r+')
        );
        $mockResponse->setBody($mockResponseBody);

        $mockResponse->setHeaders(array(
            "Host" => "httpbin.org",
            "User-Agent" => "curl/7.19.7 (universal-apple-darwin10.0) libcurl/7.19.7 OpenSSL/0.9.8l zlib/1.2.3",
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ));

        $plugin = new MockPlugin();
        $plugin->addResponse($mockResponse);
        $client = new Client();
        $client->addSubscriber($plugin);

        $downloader->setClient($client);

        return $downloader;
    }

    /**
     * @return array
     */
    public function getTestDownloaderData()
    {
        $out = [];

        // Case #0
        $fixture = 'currenciesToDownload.xml';
        $expected = '<rss>currencies</rss>';

        $out[] = [$fixture, $expected, true];

        // Case #1
        $fixture = 'currenciesToDownload.xml';
        $expected = false;

        $out[] = [$fixture, $expected, false];

        return $out;
    }

    /**
     * @dataProvider getTestDownloaderData()
     *
     * @param $fixture
     * @param $expected
     */
    public function testCurrencies($fixture, $expected, $mock)
    {
        $service = $this->getDownloader($fixture, $mock);

        $actual = $service->getContent($this->getFixturePath($fixture));

        $this->assertEquals($expected, $actual);
    }
}

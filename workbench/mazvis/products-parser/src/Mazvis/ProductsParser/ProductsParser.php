<?php

namespace Mazvis\ProductsParser;

use Guzzle\Http\Client;
use GuzzleHttp\Tests\Adapter\Curl\CurlAdapterTest;
use Mazvis\ProductsParser\Configs\Providers\VarleLtConfig;
use Mazvis\ProductsParser\Models\Product;
use Mazvis\ProductsParser\Models\ProductModel;
use Mazvis\ProductsParser\Services\CurrencyService\CurrencyService;

class ProductsParser
{
    public function getCurrencies()
    {
        $currencyService = new CurrencyService();
        $currencyService->getCurrentCurrencies();
    }

    public static function writeToDatabase()
    {
        $parser = new ProductsParser();
        $result = $parser->curlVarleLtPage();
        $fileName  = $result[0];
        $timestamp = $result[1];
        $parser->readFileClone($fileName, $timestamp, true);
    }

    public function curlVarleLtPage()
    {
        $config = new VarleLtConfig();
        $categoryLinks = $config->getCategoryLinks();
        $varleLtCurl = $config->getVarleLtCurlInstance();


        $date = new \DateTime();
        $timestamp = $date->getTimestamp();

        $filePath = $this->getFilePath($config->getProvider(), $timestamp);

//        $products = [];
        $this->openFile($filePath);
        foreach ($categoryLinks as $key => $link) {
            $products = $varleLtCurl->curlData($link);
            $this->writeProductsToFile($products, $filePath, $key, count($categoryLinks));
//            $products = array_merge($products, $products);
        }
        $this->closeFile($filePath);

        return [$filePath, $timestamp];
    }

    protected function writeProductsToFile($products, $file, $currentLinkKey, $linksCount)
    {
        $comma = ',';
        /** @var Product $product */
        foreach ($products as $key => $product) {
            if (($currentLinkKey+1) == $linksCount && ($key+1) == count($products)){
                $comma = '';
            }
            $product->setDescription($product->getDescription());
            file_put_contents($file, json_encode($product->dump()) . $comma. "\n", FILE_APPEND);
        }
    }

    protected function openFile($file)
    {
        file_put_contents($file, "[\n");
    }

    protected function closeFile($file)
    {
        file_put_contents($file, "]\n", FILE_APPEND);
    }

    /**
     * @param $dirName
     */
    protected function createDir($dirName)
    {
        if (!file_exists($dirName)) {
            mkdir($dirName, 0777, true);
        }
    }

    protected function getFilePath($provider, $timestamp)
    {
        $dir = sprintf('%s%s%s%s%s%s%s%s%s%s%s',
            '..',
            DIRECTORY_SEPARATOR,
            'app',
            DIRECTORY_SEPARATOR,
            'data',
            DIRECTORY_SEPARATOR,
            $provider,
            DIRECTORY_SEPARATOR,
            date('Y-m-d'),
            DIRECTORY_SEPARATOR,
            $timestamp
        );
        $this->createDir($dir);

        $fileName = 'products.json';
        $filePath = $dir . DIRECTORY_SEPARATOR . $fileName;

        return $filePath;
    }

    protected function readFileClone($fileName, $timestamp, $writeToDatabase = false)
    {
        //$timestamp = date('Y-m-d H:i:s', (int) $timestamp);
        var_dump($timestamp);

        $dateTime = new \DateTime();
        $dateTime->setTimestamp($timestamp);

//        var_dump($dateTime);

        $file = fopen($fileName, "r");
        while(!feof($file)){
            $line = fgets($file);
            if (strlen($line) > 0) {
                if ($line[0] == '[' || $line[0] == ']') {
                    continue;
                }
                $last = substr($line, -2, 1);
                if ($last == ',') {
                    $line = substr($line, 0, strlen($line)-2);
                } else {
                    $line = substr($line, 0, strlen($line)-1);
                }
                if ($writeToDatabase) {
                    $product = json_decode($line, true);
                    $product['images']    = json_encode($product['images']);
                    $product['timestamp'] = (int) $timestamp;
                    ProductModel::create($product);
                }
            }
        }
        fclose($file);
    }

    protected function readFile($fileName, $writeToDatabase = false)
    {
        $file = fopen($fileName, "r");
        while(!feof($file)){
            $line = fgets($file);
            if (strlen($line) > 0) {
                if ($line[0] == '[' || $line[0] == ']') {
                    continue;
                }
                $last = substr($line, -2, 1);
                if ($last == ',') {
                    $line = substr($line, 0, strlen($line)-2);
                } else {
                    $line = substr($line, 0, strlen($line)-1);
                }
                if ($writeToDatabase) {
                    $product = json_decode($line, true);
                    $product['images']    = json_encode($product['images']);
                    //$product['timestamp'] = new \DateTime();
                    ProductModel::create($product);
                }
            }
        }
        fclose($file);
    }

//    /**
//     * @return bool|string
//     */
//    public function curlSkytechPage() {
//
//        //skytech
//        $baseUrl = 'http://www.skytech.lt/';
//        $url = 'http://www.skytech.lt/nesiojami-kompiuteriai-notebook-c-86_165_1281_81.html';
//
//        $options = [
//            'curl.options' => [
//                CURLOPT_SSL_VERIFYPEER => 0,
//                CURLOPT_SSL_VERIFYHOST => 0,
//            ]
//        ];
//
//        $guzzleHttpClient = new Client($baseUrl, $options);
//
//        $curl = new Curl();
//        $curl->setClient($guzzleHttpClient);
//
//        return $curl->getRemoteFileContent($url);
//    }
}
<?php

namespace Mazvis\ProductsParser;

use Mazvis\ProductsParser\Models\ProductModel;

class Parser
{
    /**
     * @param $file
     */
    protected function openFile($file)
    {
        file_put_contents($file, "[\n");
    }

    /**
     * @param $file
     */
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

    /**
     * @param $provider
     * @param $timestamp
     * @return string
     */
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

    /**
     * @param $fileName
     * @param $timestamp
     * @param bool $writeToDatabase
     */
    protected function readFile($fileName, $timestamp, $writeToDatabase = false)
    {
        $file = fopen($fileName, "r");
        while (!feof($file)) {
            $line = fgets($file);
            if (strlen($line) > 0) {
                if ($line[0] == '[' || $line[0] == ']') {
                    continue;
                }
                $last = substr($line, -2, 1);
                if ($last == ',') {
                    $line = substr($line, 0, strlen($line) - 2);
                } else {
                    $line = substr($line, 0, strlen($line) - 1);
                }
                if ($writeToDatabase) {
                    $product = json_decode($line, true);
                    $product['images'] = json_encode($product['images']);
                    $product['timestamp'] = (int) $timestamp;
                    ProductModel::create($product);
                }
            }
        }
        fclose($file);
    }
}
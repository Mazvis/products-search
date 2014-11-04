<?php

namespace Mazvis\ProductsParser;

use Mazvis\ProductsParser\Configs\DownloaderConfig;
use Mazvis\ProductsParser\Configs\Providers\VarleLtConfig;
use Mazvis\ProductsParser\Models\Product;
use Mazvis\ProductsParser\Services\CurrencyService\CurrencyService;
use Mazvis\ProductsParser\Services\DatabaseHelper;

class ProductsParser extends Parser
{
    /**
     * Download and save currencies
     */
    public static function getCurrencies()
    {
        $currencyService = new CurrencyService();
        $currencyService->setDownloader(DownloaderConfig::getDownloaderInstance());
        $currencyService->getCurrentCurrencies();
    }

    /**
     * Writes VarleLt products to database
     */
    public function writeToDatabase()
    {
        $result = $this->curlVarleLtPage();
        $fileName  = $result[0];
        $timestamp = $result[1];
        $this->readFile($fileName, $timestamp, true);
    }

    /**
     * Curls VarleLt products and writes into a file
     *
     * @return array
     */
    protected function curlVarleLtPage()
    {
        $config = new VarleLtConfig();
        $categoryLinks = $config->getCategoryLinks();
        $varleLtCurl = $config->getVarleLtCurlInstance();

        $date = new \DateTime();
        $timestamp = $date->getTimestamp();

        $filePath = $this->getFilePath($config->getProvider(), $timestamp);

        $this->openFile($filePath);
        foreach ($categoryLinks as $key => $link) {
            $products = $varleLtCurl->curlData($link);
            $this->writeProductsToFile($products, $filePath, $key, count($categoryLinks));
        }
        $this->closeFile($filePath);

        return [$filePath, $timestamp];
    }

    /**
     * Save products in JSON format file
     *
     * @param $products
     * @param $file
     * @param $currentLinkKey
     * @param $linksCount
     */
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

    /**
     * @return array
     */
    public static function getExistingCategories()
    {
        return DataBaseHelper::getExistingCategories();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getProducts()
    {
        return DataBaseHelper::getProducts();
    }

    /**
     * @param $category
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getProductsByCategory($category)
    {
        return DataBaseHelper::getProductsByCategory($category);
    }

    /**
     * @param $country
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getProductsByCountry($country)
    {
        return DataBaseHelper::getProductsByCountry($country);
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getProductsByCostAsc()
    {
        return DataBaseHelper::getProductsByCostAsc();
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getProductsByCostDesc()
    {
        return DataBaseHelper::getProductsByCostDesc();
    }
}
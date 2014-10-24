<?php

use Mazvis\ProductsParser\ProductsParser;

class ProductsController extends BaseController
{
    public function writeProductsToDatabase()
    {
        $parser = new ProductsParser();
        $fileName = $parser->curlVarleLtPage();

        $this->readFile($fileName);
    }

    protected function readFile($fileName)
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
                $product = json_decode($line, true);
                $product['images'] = json_encode($product['images']);
                Product::create($product);
            }
        }
        fclose($file);
    }
}
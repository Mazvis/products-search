<?php

use Mazvis\ProductsParser\Models\Product;

/**
 * Class ProductTest
 */
class ProductTest extends PHPUnit_Framework_TestCase
{
    /**
     * testing the model dump method
     */
    public function testDump()
    {
        $expected = [
            "provider" => "providerName",
            "category" => null,
            "name" => null,
            "description" => "desc",
            "deepLink" => "link.html",
            "images" => ["img.jpg"],
            "providerQuantity" => null,
            "country" => "Lithuania",
            "originalPrice" => 500,
            "originalCurrency" => "EUR",
            "convertedPrice" => null,
            "convertedCurrency" => null
        ];

        $actual = new Product();
        $actual->setProvider("providerName");
        $actual->setDescription("desc");
        $actual->setDeepLink("link.html");
        $actual->setImages(["img.jpg"]);
        $actual->setCountry("Lithuania");
        $actual->setOriginalPrice(500);
        $actual->setOriginalCurrency("EUR");

        $this->assertEquals($expected, $actual->dump());
    }
}

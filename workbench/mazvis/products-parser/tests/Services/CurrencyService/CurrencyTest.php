<?php

use Mazvis\ProductsParser\Services\CurrencyService\Currency;

class CurrencyTest extends PHPUnit_Framework_TestCase
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

    /**
     * @return Currency
     */
    public function getCurrencyHelper()
    {
        $service = new Currency();
        $service->setBaseCurrency('EUR');
        $service->setPathToLoad($this->getFixturePath('currencies.json'));

        return $service;
    }

    /**
     * @return array
     */
    public function getTestCurrencyHelper()
    {
        $out = [];

        // Case #0
        $price = 50;
        $currency = 'EUR';
        $expected = [
            'price'    => 50,
            'currency' => 'EUR'
        ];

        $out[] = [$price, $currency, $expected];

        // Case #1
        $price = 346;
        $currency = 'LTL';
        $expected = [
            'price'    => 100.21,
            'currency' => 'EUR'
        ];

        // Case #2
        $price = 511;
        $currency = 'USD';
        $expected = [
            'price'    => 400.45,
            'currency' => 'EUR'
        ];

        $out[] = [$price, $currency, $expected];

        // Case #3
        // bad currency
        $price = 500;
        $currency = 'BAD';
        $expected = [
            'price'    => null,
            'currency' => null
        ];

        $out[] = [$price, $currency, $expected];

        return $out;
    }

    /**
     * @dataProvider getTestCurrencyHelper()
     *
     * @param $price
     * @param $currency
     * @param $expected
     */
    public function testCurrencyHelper($price, $currency, $expected)
    {
        $service = $this->getCurrencyHelper();

        $service->convertPrice($price, $currency);
        $actual = [
            'price'    => $service->getConvertedPrice(),
            'currency' => $service->getConvertedCurrency()
        ];

        $this->assertEquals($expected, $actual);
    }
}

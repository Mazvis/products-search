<?php

use Mazvis\ProductsParser\Services\CurrencyService\CurrencyService;

class CurrencyServiceTest extends PHPUnit_Framework_TestCase
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
     * @param string $fixture
     *
     * @return string
     */
    public function getContent($fixture)
    {
        if (file_exists($fixture)) {
            return file_get_contents($fixture);
        }

        return '';
    }

    /**
     * @param $fixture
     * @return CurrencyService
     */
    public function getCurrencyService($fixture)
    {
        $service = new CurrencyService();
        $service->setCurrenciesLink($this->getFixturePath($fixture));
        $service->setPathToSave($this->getFixturePath('') . 'dir' . DIRECTORY_SEPARATOR);
        $service->setFileName('saved_currencies.json');

        // Downloader
        $downloader = $this->getMock(
            'Mazvis\ProductsParser\Services\Downloader',
            ['getContent']
        );
        $downloader
            ->expects($this->any())->method('getContent')
            ->will($this->returnValue($this->getContent($this->getFixturePath($fixture))));

        $service->setDownloader($downloader);

        return $service;
    }

    /**
     * @return array
     */
    public function getTestCurrencies()
    {
        $out = [];

        // Case #0
        $fixture = 'currencies.xml';
        $expected = [
            'EUR' => 1.0,
            'LTL' => 0.2896200185356812,
            'RUB' => 0.019242351646279396,
            'USD' => 0.78366221024089777
        ];

        $out[] = [$fixture, $expected];

        return $out;
    }

    /**
     * @dataProvider getTestCurrencies()
     *
     * @param $fixture
     * @param $expected
     */
    public function testCurrencies($fixture, $expected)
    {
        $service = $this->getCurrencyService($fixture);

        $service->getCurrentCurrencies();
        $actual = $service->getCurrencies();

        $this->assertEquals($expected, $actual);

        $this->deteleTempDir();
    }

    /**
     * Delete temp dir
     */
    private function deteleTempDir()
    {
        $dir = $this->getFixturePath('') . 'dir' . DIRECTORY_SEPARATOR;
        if (file_exists($dir)) {
            exec('rm -rf ' . $dir);
        }
    }
}

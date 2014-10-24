<?php

use Guzzle\Http\Client;
use Mazvis\ProductsParser\Models\Product;
use Mazvis\ProductsParser\Providers\VarleLt\Services\Curl;
use Mazvis\ProductsParser\Services\CurrencyService\Currency;

class CurlTest extends \PHPUnit_Framework_TestCase
{
    /** @var string  */
    private $provider = 'VarleLt';

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
     * @param bool $pageLimit
     *
     * @return Curl
     */
    public function getCurlService($fixture = false, $pageLimit = false, $fixtures = null)
    {
        $curl = new Curl();

        $curl->setProvider($this->provider);
        $curl->setCountry('Lithuania');

        $curl->setCategoryMap(
            ['Nešiojami kompiuteriai' => Product::CATEGORY_LAPTOP]
        );

        $curl->setBaseUrl('https://www.varle.lt');

        // Currency
        $currencyMock = $this->getMock('Mazvis\ProductsParser\Services\CurrencyService\Currency');
        $currencyMock
            ->expects($this->any())->method('getConvertedCurrency')
            ->will($this->returnValue(null));
        $currencyMock
            ->expects($this->any())->method('getConvertedPrice')
            ->will($this->returnValue(null));
        $curl->setCurrency($currencyMock);

        // TidyService
        $tidy = $this->getMock('Mazvis\ProductsParser\Services\TidyService', ['tidyTheContent']);

        // Downloader
        $downloader = $this->getMock('Mazvis\ProductsParser\Services\Downloader');

        if (!$fixtures) {
            $tidy
                ->expects($this->any())->method('tidyTheContent')
                ->will($this->returnValue($this->getContent($this->getFixturePath($fixture))));
            $curl->setTidyService($tidy);

            // Downloader
            $downloader
                ->expects($this->any())->method('getContent')
                ->will($this->returnValue($this->getContent($this->getFixturePath($fixture))));
            $curl->setDownloader($downloader);
        } else {
            // TidyService
            foreach ($fixtures as $key => $fixture) {
                $tidy
                    ->expects($this->at($key))->method('tidyTheContent')
                    ->will($this->returnValue($this->getContent($this->getFixturePath($fixture))));
            }
            $curl->setTidyService($tidy);

            // Downloader
            foreach ($fixtures as $key => $fixture) {
                $downloader
                    ->expects($this->at($key))->method('getContent')
                    ->will($this->returnValue($this->getContent($this->getFixturePath($fixture))));
            }
            $curl->setDownloader($downloader);
        }

        if ($pageLimit) {
            $curl->setPageLimit($pageLimit);
        }

        return $curl;
    }

    /**
     * @return array
     */
    public function getTestTotalPageCountData()
    {
        $out = [];

        //case #0
        $fixture = 'varleLt_firstProductsPage.html';
        $expected = 33;
        $pageLimit = false;
        $out[] = [$fixture, $expected, $pageLimit];

        //case #1
        $fixture = 'varleLt_firstProductsPage.html';
        $expected = 2;
        $pageLimit = 2;
        $out[] = [$fixture, $expected, $pageLimit];

        return $out;
    }

    /**
     * @dataProvider getTestTotalPageCountData()
     *
     * @return void
     */
    public function testTotalPageCount($fixture, $expected, $pageLimit)
    {
        $curl = $this->getCurlService($fixture, $pageLimit);

        $current = $curl->getTotalPageCount($fixture);

        $this->assertEquals($expected, $current);
    }

    /**
     * @return array
     */
    public function getTestPageLinksData()
    {
        $out = [];

        //case #0
        $firstPageUrl = 'https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/?show=grid';
        $totalPages = 4;
        $expected = [
            'https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/?show=grid&p=1',
            'https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/?show=grid&p=2',
            'https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/?show=grid&p=3',
            'https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/?show=grid&p=4'
        ];
        $out[] = [$firstPageUrl, $totalPages, $expected];

        return $out;
    }

    /**
     * @dataProvider getTestPageLinksData()
     *
     * @return void
     */
    public function testPageLinks($firstPageUrl, $totalPages, $expected)
    {
        $curl = $this->getCurlService('foo.bar');

        $current = $curl->generatePageLinks($firstPageUrl, $totalPages);

        $this->assertEquals($expected, $current);
    }

    /**
     * @return array
     */
    public function getTestPageProductsData()
    {
        $out = [];

        //case #0
        $fixture = 'varleLt_firstProductsPage.html';

        //#1 product
        $products = [];
        $product = new Product();
        $product->setProvider($this->provider);
        $product->setCategory(Product::CATEGORY_LAPTOP);
        $product->setDescription('Nešiojamas kompiuteris Acer E5-571 15.6" LED matinis / Intel Core i7-4510U iki 3.1Ghz');
        $product->setImages(
            ['https://www.varle.lt/static/uploads/products/235x195/26/nes/nesiojamas-kompiuteris-acer-e5-571-156_5.jpg']
        );
        $product->setDeepLink('https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/nesiojamas-kompiuteris-acer-e5-571-156-led-matinis--959338.html');
        $product->setCountry('Lithuania');
        $product->setOriginalPrice(578.95);
        $product->setOriginalCurrency('EUR');
        $products[] = $product;

        //#2 product
        $product = new Product();
        $product->setProvider($this->provider);
        $product->setCategory(Product::CATEGORY_LAPTOP);
        $product->setDescription('Nešiojamas kompiuteris DELL Inspiron 15 (3542)  15.6" HD LED / Intel Core i5-4210U');
        $product->setImages(
            ['https://www.varle.lt/static/uploads/products/235x195/26/nes/nesiojamas-kompiuteris-dell-inspiron-15_13.jpg']
        );
        $product->setDeepLink('https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/nesiojamas-kompiuteris-dell-inspiron-15-3542-156.html');
        $product->setCountry('Lithuania');
        $product->setOriginalPrice(492.06);
        $product->setOriginalCurrency('EUR');
        $products[] = $product;

        $out[] = [$fixture, $products];

        return $out;
    }

    /**
     * @dataProvider getTestPageProductsData()
     *
     * @return void
     */
    public function testPageProductData($fixture, $expected)
    {
        $curl = $this->getCurlService($fixture);

        $current = $curl->getPageProducts($fixture);

        $this->assertEquals($expected, $current);
    }

    /**
     * @return array
     */
    public function getTestCurlData()
    {
        $out = [];

        //case #0
        $fixtures = [
            'integration' . DIRECTORY_SEPARATOR . 'varleLt_firstProductsPage.html&p=1',
            'integration' . DIRECTORY_SEPARATOR . 'varleLt_firstProductsPage.html&p=1',
            'integration' . DIRECTORY_SEPARATOR . 'varleLt_firstProductsPage.html&p=2',
        ];

        //#1 product
        $products = [];
        $product = new Product();
        $product->setProvider($this->provider);
        $product->setCategory(Product::CATEGORY_LAPTOP);
        $product->setDescription('Nešiojamas kompiuteris Acer E5-571 15.6" LED matinis / Intel Core i7-4510U iki 3.1Ghz');
        $product->setImages(
            ['https://www.varle.lt/static/uploads/products/235x195/26/nes/nesiojamas-kompiuteris-acer-e5-571-156_5.jpg']
        );
        $product->setDeepLink('https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/nesiojamas-kompiuteris-acer-e5-571-156-led-matinis--959338.html');
        $product->setCountry('Lithuania');
        $product->setOriginalPrice(578.95);
        $product->setOriginalCurrency('EUR');
        $products[] = $product;

        //#2 product
        $product = new Product();
        $product->setProvider($this->provider);
        $product->setCategory(Product::CATEGORY_LAPTOP);
        $product->setDescription('Nešiojamas kompiuteris DELL Inspiron 15 (3542)  15.6" HD LED / Intel Core i5-4210U');
        $product->setImages(
            ['https://www.varle.lt/static/uploads/products/235x195/26/nes/nesiojamas-kompiuteris-dell-inspiron-15_13.jpg']
        );
        $product->setDeepLink('https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/nesiojamas-kompiuteris-dell-inspiron-15-3542-156.html');
        $product->setCountry('Lithuania');
        $product->setOriginalPrice(492.06);
        $product->setOriginalCurrency('EUR');
        $products[] = $product;

        //#3 product
        $product = new Product();
        $product->setProvider($this->provider);
        $product->setCategory(Product::CATEGORY_LAPTOP);
        $product->setDescription('Nešiojamas kompiuteris Acer E5-571 15.6" LED matinis / Intel Core i7-4510U iki 3.1Ghz');
        $product->setImages(
            ['https://www.varle.lt/static/uploads/products/235x195/26/nes/nesiojamas-kompiuteris-acer-e5-571-156_5.jpg']
        );
        $product->setDeepLink('https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/nesiojamas-kompiuteris-acer-e5-571-156-led-matinis--959338.html');
        $product->setCountry('Lithuania');
        $product->setOriginalPrice(578.95);
        $product->setOriginalCurrency('EUR');
        $products[] = $product;

        //#4 product
        $product = new Product();
        $product->setProvider($this->provider);
        $product->setCategory(Product::CATEGORY_LAPTOP);
        $product->setDescription('Nešiojamas kompiuteris DELL Inspiron 15 (3542)  15.6" HD LED / Intel Core i5-4210U');
        $product->setImages(
            ['https://www.varle.lt/static/uploads/products/235x195/26/nes/nesiojamas-kompiuteris-dell-inspiron-15_13.jpg']
        );
        $product->setDeepLink('https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/nesiojamas-kompiuteris-dell-inspiron-15-3542-156.html');
        $product->setCountry('Lithuania');
        $product->setOriginalPrice(500.50);
        $product->setOriginalCurrency('EUR');
        $products[] = $product;

        $out[] = [$products, $fixtures];

        return $out;
    }

    /**
     * @dataProvider getTestCurlData()
     *
     * @param $expected
     * @param $fixtures
     */
    public function testCurlData($expected, $fixtures)
    {
        $curl = $this->getCurlService(false, false, $fixtures);

        $current = $curl->curlData($this->getFixturePath($fixtures[0]));

        $aa = ['Mazvis\ProductsParser\Models\Product', 'Mazvis\ProductsParser\Providers\VarleLt\Services\Curl'];
        foreach ($aa as $aaa) {
            $a = new $aaa;
            if (method_exists($a, 'getProvider')) {
                var_dump($a->getProvider());
            }
            if (method_exists($a, 'getBaseUrl')) {
                var_dump($a->getBaseUrl());
            }
        }

        $this->assertEquals($expected, $current);
    }
}

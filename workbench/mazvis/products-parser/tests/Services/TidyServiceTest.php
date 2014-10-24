<?php
use Mazvis\ProductsParser\Services\TidyService;

class TidyServiceTest extends PHPUnit_Framework_TestCase
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

    public function getTidyService()
    {
        $service = new TidyService();
        return $service;
    }

    /**
     * @return array
     */
    public function getTestTidyData()
    {
        $out = [];

        // Case #0
        $fixture = 'content_to_tidy.xml';
        $expected =  $this->getContent($this->getFixturePath('expected_tidy.xml'));

        $doc = new \DOMDocument();
        $doc->loadHTML($expected);
        $expected = trim($doc->saveHTML());

        $out[] = [$fixture, $expected];

        return $out;
    }

    /**
     * @dataProvider getTestTidyData()
     *
     * @param $fixture
     * @param $expected
     */
    public function testTidyData($fixture, $expected)
    {
        $service = $this->getTidyService($fixture);

        $actual = $service->tidyTheContent($this->getContent($this->getFixturePath($fixture)));

        $doc = new \DOMDocument();
        $doc->loadHTML($actual);
        $actual = trim($doc->saveHTML());

        $this->assertSame($expected, $actual);
    }


}
 
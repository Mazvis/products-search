<?php

namespace Mazvis\ProductsParser\Services;

use Mazvis\ProductsParser\Services\CurrencyService\Currency;

class PageCurl
{
    /** @var  string */
    protected $provider;
    /** @var  string */
    protected $country;
    /** @var  string */
    protected $categoryMap;
    /** @var  Currency */
    protected $currency;
    /** @var  TidyService */
    protected $tidyService;
    /** @var  Downloader */
    protected $downloader;

    /**
     * @param \DOMDocument $doc
     * @param string $query
     *
     * @return string
     */
    protected function getInnerHtmlByQuery($doc, $query)
    {
        $finder = new \DomXPath($doc);
        $nodes = $finder->query($query);

        $tmpDom = new \DOMDocument();
        foreach ($nodes as $node) {
            $tmpDom->appendChild($tmpDom->importNode($node, true));
        }

        $innerHTML = trim($tmpDom->saveHTML());

        return $innerHTML;
    }

    /**
     * @param string $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param string $categoryMap
     */
    public function setCategoryMap($categoryMap)
    {
        $this->categoryMap = $categoryMap;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param TidyService $tidyService
     */
    public function setTidyService($tidyService)
    {
        $this->tidyService = $tidyService;
    }

    /**
     * @param Downloader $downloader
     */
    public function setDownloader($downloader)
    {
        $this->downloader = $downloader;
    }
}

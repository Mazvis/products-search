<?php

namespace Mazvis\ProductsParser\Providers\VarleLt\Services;

use Guzzle\Http\Client;
use Mazvis\ProductsParser\Models\Product;
use Mazvis\ProductsParser\Services\PageCurl;

class Curl extends PageCurl
{
    /** @var  string */
    private $baseUrl;

    /** @var  int */
    protected $pageLimit;

    /**
     * @param string $url
     * @return int
     */
    public function getTotalPageCount($url)
    {
        $pagesCount = 1;

        $content = $this->downloader->getContent($url);

        if ($content) {
            //tide the html content
            $content = $this->tidyService->tidyTheContent($content);

            //create dom doc from content
            $doc = new \DOMDocument();
            $doc->loadHTML($content);

            //find pages
            $className = 'pagination';
            $query = "//div[@class='" . $className . "']";
            $innerHTML = $this->getInnerHtmlByQuery($doc, $query);

            //find total pages count
            $xml = simplexml_load_string($innerHTML);

            /** @var \SimpleXMlElement $child */
            foreach ($xml->children() as $child) {
                if ($child->attributes()['class'] == 'page') {
                    $pagesCount = (int) $child;
                }
            }
        }

        if ($this->pageLimit && $pagesCount > $this->pageLimit) {
            $pagesCount = $this->pageLimit;
        }

        return $pagesCount;
    }

    /**
     * @param string $firstPageUrl
     * @param int $totalPageCount
     * @return array
     */
    public function generatePageLinks($firstPageUrl, $totalPageCount) {
        $links = [];

        for ($i = 1; $i <= $totalPageCount; $i++) {
            $links[] = strpos($firstPageUrl, 'p=1') !== false ? $firstPageUrl :
                (strpos($firstPageUrl, '?') !== false ? $firstPageUrl . '&p=' . $i : $firstPageUrl . '?p=' . $i);
        }

        return $links;
    }

    /**
     * @param $content
     * @return null|string
     */
    protected function findCategory($content)
    {
        //create dom doc from content
        $doc = new \DOMDocument();
        $doc->loadHTML($content);

        //find category
        $idName = 'crumbs';
        $query = "//ul[@id='" . $idName . "']";
        $innerHTMLCategory = $this->getInnerHtmlByQuery($doc, $query);

        $category = null;

        if ($innerHTMLCategory != '') {
            $doc = new \DOMDocument();
            $doc->loadHTML($innerHTMLCategory);

            $elements = $doc->getElementsByTagName('li');
            foreach($elements as $node){
                $class = trim($node->getAttribute('class'));
                if ($class == 'last') {
                    $elements = $node->getElementsByTagName('a');
                    foreach($elements as $el){
                        $category = trim($el->nodeValue);
                        break; //break 2;
                    }
                }
            }
        }

        return $category;
    }


    /**
     * @param string $url
     * @return array
     */
    public function getPageProducts($url) {
        $products = [];

        $content = $this->downloader->getContent($url);
        if ($content) {
            //tide the html content
            $content = $this->tidyService->tidyTheContent($content);

            $category = $this->findCategory($content);
            var_dump($category);

            //create dom doc from content
            $doc = new \DOMDocument();
            $doc->loadHTML($content);

            //find products
            $idName = 'ajax-container';
            $query = "//div[@id='" . $idName . "']";
            $innerHTML = $this->getInnerHtmlByQuery($doc, $query);

            $doc = new \DOMDocument();
            $doc->loadHTML($innerHTML);

            $elements = $doc->getElementsByTagName('div');
            foreach($elements as $node){
                /** @var \DOMElement $child */
                foreach($node->childNodes as $child) {
                    if ($child->nodeName == 'a') {
                        $deepLink = $child->getAttribute('href');

                        $product = new Product();
                        $product->setProvider($this->provider);
                        $product->setCountry($this->country);
                        $product->setCategory(isset($this->categoryMap[$category]) ? $this->categoryMap[$category] : null);
                        $product->setDeepLink($deepLink);

                        /** @var \DOMElement $aChilds */
                        foreach($child->childNodes as $aChilds) {
                            if ($aChilds->nodeName == 'span') {
                                if ($aChilds->getAttribute('class') == 'img-container') {
                                    /** @var \DOMElement $spanChilds */
                                    foreach($aChilds->childNodes as $spanChilds) {
                                        if ($spanChilds->nodeName == 'img') {
                                            $imgLink = $spanChilds->getAttribute('data-original');
                                            if ($imgLink != '') {
                                                $product->setImages([$this->baseUrl . $imgLink]);
                                            }
                                        }
                                    }
                                } elseif ($aChilds->getAttribute('class') == 'prices') {
                                    /** @var \DOMElement $spanChilds */
                                    foreach($aChilds->childNodes as $spanChilds) {
                                        if ($spanChilds->nodeName == 'span' && $spanChilds->getAttribute('class') == 'euro_price') {
                                            $euroPrice = $spanChilds->nodeValue;
                                            $euroPrice = substr($euroPrice, strpos($euroPrice, "¬") + 2);
                                            $euroPrice = str_replace(',', '.', $euroPrice);
                                            $euroPrice = trim($euroPrice);
                                            $euroPrice = str_replace('€', '', $euroPrice);

                                            $product->setOriginalPrice((double) $euroPrice);
                                            $product->setOriginalCurrency('EUR');
                                            $this->currency->convertPrice($euroPrice, "EUR");

                                            $product->setConvertedPrice($this->currency->getConvertedPrice());
                                            $product->setConvertedCurrency($this->currency->getConvertedCurrency());
                                        }
                                    }
                                } elseif ($aChilds->getAttribute('class') == 'title') {
                                    /** @var \DOMElement $spanChilds */
                                    foreach($aChilds->childNodes as $spanChilds) {
                                        if ($spanChilds->nodeName == 'span' && $spanChilds->getAttribute('class') == 'inner') {
                                            $description = $spanChilds->nodeValue;

                                            $product->setDescription(trim($description));
                                        }
                                    }
                                }
                            }
                        }
                        if ($product->getOriginalPrice() > 0) {
                            $products[] = $product;
                        }
                    }
                }
            }

        }

        return $products;
    }

    /**
     * @param string $firstPageUrl
     *
     * @return array
     */
    public function curlData($firstPageUrl) {
        $totalPageCount = $this->getTotalPageCount($firstPageUrl);
        $links = $this->generatePageLinks($firstPageUrl, $totalPageCount);

        $products = [];
        foreach ($links as $link) {
            $products = array_merge($products, $this->getPageProducts($link));
        }

        return $products;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param int $pageLimit
     */
    public function setPageLimit($pageLimit)
    {
        $this->pageLimit = $pageLimit;
    }
}
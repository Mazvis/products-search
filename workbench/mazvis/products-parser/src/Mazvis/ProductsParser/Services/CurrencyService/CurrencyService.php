<?php

namespace Mazvis\ProductsParser\Services\CurrencyService;

class CurrencyService
{
    /** @var string */
    protected $currenciesLink = 'http://themoneyconverter.com/rss-feed/EUR/rss.xml';
    /** @var string */
    protected $baseCurrency = 'EUR';
    /** @var string  */
    protected $pathToSave = 'currencies.json';

    /** @var array */
    protected $currencies = [];

    public function getCurrentCurrencies()
    {
        $content = file_get_contents($this->currenciesLink);

        if ($content != '') {
            $xml = simplexml_load_string($content);
            if ($xml) {
                /** @var \SimpleXmlElement $channel */
                $channel = $xml->{'channel'};
                /** @var \SimpleXmlElement $element */
                foreach ($channel->children() as $element) {
                    if ($element->getName() == 'item') {

                        $title = (string) $element->{'title'};
                        $titles = explode('/', $title);
                        $foreignCurrency = $titles[0];

                        $description = (string) $element->{'description'};
                        $startPos = strpos($description, '=') + 2;
                        $endPos = strpos($description, ' ', $startPos);
                        $price = substr($description, $startPos, $endPos-$startPos);
                        $price = (double) $price;

                        $this->currencies[$foreignCurrency] = 1 / $price;
                    }
                }
            }

            $this->saveCurrencies();
        }
    }

    /**
     * Save downloaded currencies
     */
    public function saveCurrencies()
    {
        if (!empty($this->currencies)) {
            file_put_contents($this->pathToSave, json_encode($this->currencies));
        }
    }

    /**
     * @param string $currenciesLink
     */
    public function setCurrenciesLink($currenciesLink)
    {
        $this->currenciesLink = $currenciesLink;
    }

    /**
     * @param string $pathToSave
     */
    public function setPathToSave($pathToSave)
    {
        $this->pathToSave = $pathToSave;
    }

    /**
     * @return array
     */
    public function getCurrencies()
    {
        return $this->currencies;
    }
}
<?php

namespace Mazvis\ProductsParser\Configs\Providers;

use Guzzle\Http\Client;
use Mazvis\ProductsParser\Models\Product;
use Mazvis\ProductsParser\Providers\VarleLt\Services\Curl;
use Mazvis\ProductsParser\Services\CurrencyService\Currency;
use Mazvis\ProductsParser\Services\Downloader;
use Mazvis\ProductsParser\Services\TidyService;

class VarleLtConfig
{
    /** @var string */
    private $provider = 'varleLt';
    /** @var string */
    private $baseUrl = 'https://www.varle.lt';
    /** @var int */
    private $pageLimit = 1;
    /** @var array  */
    private $categoryMap = [
        'Nešiojami kompiuteriai'  => Product::CATEGORY_LAPTOP,
        'NeÅ¡iojami kompiuteriai' => Product::CATEGORY_LAPTOP,
        'Kompiuterių kolonėlės'   => Product::CATEGORY_AUDIO_SPEAKERS,
        'Kompiuterių
                  kolonėlės'      => Product::CATEGORY_AUDIO_SPEAKERS,
        'KompiuteriÅ³
                  kolonÄ—lÄ—s'  => Product::CATEGORY_AUDIO_SPEAKERS,
        'Klaviatūros'             => Product::CATEGORY_KEYBOARD,
        'KlaviatÅ«ros'            => Product::CATEGORY_KEYBOARD
    ];
    /** @var string  */
    private $country = 'Lithuania';
    /** @var array  */
    private $categoryLinks = [
        'https://www.varle.lt/nesiojami-kompiuteriai/nesiojami-kompiuteriai/?sort=price&show=grid',
        'https://www.varle.lt/kompiuteriu-koloneles/?show=grid',
        'https://www.varle.lt/klaviaturos/?show=grid',
    ];

    /**
     * @return Curl
     */
    public function getVarleLtCurlInstance()
    {
        $varleLtCurl = new Curl();

        $options = [
            'curl.options' => [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
            ]
        ];

        $varleLtCurl->setProvider($this->provider);
        $varleLtCurl->setCountry($this->country);
        $varleLtCurl->setCategoryMap($this->categoryMap);
        $varleLtCurl->setBaseUrl($this->baseUrl);
        $varleLtCurl->setPageLimit($this->pageLimit);

        $varleLtCurl->setCurrency(new Currency());
        $varleLtCurl->setTidyService(new TidyService());

        $downloader = new Downloader();
        $downloader->setClient(new Client($this->baseUrl, $options));
        $varleLtCurl->setDownloader($downloader);

        return $varleLtCurl;
    }

    /**
     * @return array
     */
    public function getCategoryLinks()
    {
        return $this->categoryLinks;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }
}

<?php

namespace Mazvis\ProductsParser\Models;

class Product
{
    /** @var  string */
    private $provider;
    /** @var  int */
    private $providerQuantity;
    /** @var  string */
    private $name;
    /** @var  string */
    private $category;

    /* Product categories */
    const CATEGORY_LAPTOP = 'laptop';
    const CATEGORY_AUDIO_SPEAKERS = 'audio_speakers';

    /** @var  string */
    private $description;
    /** @var  array */
    private $images;
    /** @var  string */
    private $deepLink;
    /** @var  string */
    private $country;

    /** @var  double */
    private $originalPrice;
    /** @var  string */
    private $originalCurrency;
    /** @var  double */
    private $convertedPrice;
    /** @var  string */
    private $convertedCurrency;

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @codeCoverageIgnore
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @codeCoverageIgnore
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getDeepLink()
    {
        return $this->deepLink;
    }

    /**
     * @codeCoverageIgnore
     * @param string $deepLink
     */
    public function setDeepLink($deepLink)
    {
        $this->deepLink = $deepLink;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @codeCoverageIgnore
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @codeCoverageIgnore
     * @param array $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @codeCoverageIgnore
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @codeCoverageIgnore
     * @param string $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @codeCoverageIgnore
     * @return int
     */
    public function getProviderQuantity()
    {
        return $this->providerQuantity;
    }

    /**
     * @codeCoverageIgnore
     * @param int $providerQuantity
     */
    public function setProviderQuantity($providerQuantity)
    {
        $this->providerQuantity = $providerQuantity;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getConvertedCurrency()
    {
        return $this->convertedCurrency;
    }

    /**
     * @codeCoverageIgnore
     * @param string $convertedCurrency
     */
    public function setConvertedCurrency($convertedCurrency)
    {
        $this->convertedCurrency = $convertedCurrency;
    }

    /**
     * @codeCoverageIgnore
     * @return float
     */
    public function getConvertedPrice()
    {
        return $this->convertedPrice;
    }

    /**
     * @codeCoverageIgnore
     * @param float $convertedPrice
     */
    public function setConvertedPrice($convertedPrice)
    {
        $this->convertedPrice = $convertedPrice;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getOriginalCurrency()
    {
        return $this->originalCurrency;
    }

    /**
     * @codeCoverageIgnore
     * @param string $originalCurrency
     */
    public function setOriginalCurrency($originalCurrency)
    {
        $this->originalCurrency = $originalCurrency;
    }

    /**
     * @codeCoverageIgnore
     * @return float
     */
    public function getOriginalPrice()
    {
        return $this->originalPrice;
    }

    /**
     * @codeCoverageIgnore
     * @param float $originalPrice
     */
    public function setOriginalPrice($originalPrice)
    {
        $this->originalPrice = $originalPrice;
    }

    /**
     * @return array
     */
    public function dump()
    {
        return get_object_vars($this);
    }
}

<?php

use Mazvis\ProductsParser\ProductsParser;

class HomeController extends BaseController
{
    /**
     * Show home page
     */
    public function showHome()
    {
        $this->layout->content = View::make('home');

        $content = $this->layout->content;
        $content->bodyClass = "home-page";

        $products = ProductsParser::getProducts();
        $products = json_decode($products);
        $content->products = $this->getImages($products);

        $content->textLikeTitle = 'Visi produktai';
    }

    /**
     * @param null|string $categoryName
     */
    public function showByCategory($categoryName = null)
    {
        $this->layout->content = View::make('home');

        $content = $this->layout->content;
        $content->bodyClass = "home-page";

        $content->products = [];
        $content->textLikeTitle = 'Prekių nerasta';
        if ($categoryName) {
            $products = ProductsParser::getProductsByCategory($categoryName);
            $products = json_decode($products);
            $content->products = $this->getImages($products);
            $content->textLikeTitle = Lang::has('categories.' . $categoryName) ?
                Lang::get('categories.'. $categoryName) : $categoryName;
            $content->textLikeTitle .= ' Viso(' . count($products) . ')';
        }
    }

    /**
     * @param null|string $countryName
     */
    public function showByCountry($countryName = null)
    {
        $this->layout->content = View::make('home');

        $content = $this->layout->content;
        $content->bodyClass = "home-page";

        $content->products = [];
        $content->textLikeTitle = 'no found';
        if ($countryName) {
            $products = ProductsParser::getProductsByCountry($countryName);
            $products = json_decode($products);
            $content->products = $this->getImages($products);
            $content->textLikeTitle = 'Šalies "' . $countryName . '" prekės:';
        }
    }

    /**
     * @param null|string $providerName
     */
    public function showByProvider($providerName = null)
    {
        $this->layout->content = View::make('home');

        $content = $this->layout->content;
        $content->bodyClass = "home-page";

        $content->products = [];
        $content->textLikeTitle = 'no found';
        if ($providerName) {
            $products = ProductsParser::getProductsByProvider($providerName);
            $products = json_decode($products);
            $content->products = $this->getImages($products);
            $content->textLikeTitle = 'Tiekėjo "' . $providerName . '" prekės:';
        }
    }

    /**
     * Search by query in DB
     */
    public function search()
    {
        $this->layout->content = View::make('home');

        $content = $this->layout->content;

        $keyword = Input::get('s');

        $content->products = [];
        $content->textLikeTitle = "Paieška pagal: '" . $keyword . "': ";
        $products = ProductsParser::doSearch($keyword);
        $products = json_decode($products);
        $content->products = $this->getImages($products);
    }

    /**
     * @param array $products
     *
     * @return array
     */
    private function getImages($products)
    {
        if (empty($products)) {
            return [];
        }

        $productsNew = $products;
        foreach ($products as $key => $product) {
            $productsNew[$key]->images = json_decode($product->images);
        }

        return $productsNew;
    }
}

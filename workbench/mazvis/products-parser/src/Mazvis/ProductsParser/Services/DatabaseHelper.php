<?php

namespace Mazvis\ProductsParser\Services;

use Illuminate\Support\Facades\DB;
use Mazvis\ProductsParser\Models\ProductModel;

class DatabaseHelper
{
    public static function getExistingCategories()
    {
        $categories = DB::table(ProductModel::getTableName())->select('category')->distinct()->get();
        return json_encode($categories);
    }

    public static function getProducts()
    {
        $products = ProductModel::get();
        return json_encode($products);
    }

    public static function getProductsByCategory($category)
    {
        $products = ProductModel::where('category', '=', $category)->orderBy('convertedPrice', 'ASC')->get();
        return json_encode($products);
    }

    public static function doSearch($s)
    {
        $products = ProductModel::where('description', 'LIKE', "%$s%")->orderBy('convertedPrice', 'desc')->get();
        return json_encode($products);
    }

    public static function getProductsByCountry($country)
    {
        return ProductModel::where('country', '=', $country)->get();
    }

    public static function getProductsByCostAsc()
    {
        return ProductModel::orderBy('convertedPrice', 'ASC')->get();
    }

    public static function getProductsByCostDesc()
    {
        return ProductModel::orderBy('convertedPrice', 'DESC')->get();
    }
}
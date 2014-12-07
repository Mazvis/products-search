<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use Mazvis\ProductsParser\ProductsParser;

/*--------------------------------------------------------------------------------------------------------------------*/
// Main program
/*--------------------------------------------------------------------------------------------------------------------*/

// Show home page
Route::get('/', 'HomeController@showHome');

Route::get('/category/{categoryName?}', 'HomeController@showByCategory');
Route::get('/country/{countryName?}', 'HomeController@showByCountry');
Route::get('/provider/{providerName?}', 'HomeController@showByProvider');

Route::get('/search', 'HomeController@search');

/*--------------------------------------------------------------------------------------------------------------------*/
// API
/*--------------------------------------------------------------------------------------------------------------------*/
Route::get('/get-currencies', function() {
    ProductsParser::getCurrencies();
});

Route::get('/update', function(){
    $parser = new ProductsParser();
    $parser->writeToDatabase();
});

// Db routes
Route::get('/get-existing-categories', function() {
    ProductsParser::getExistingCategories();
});
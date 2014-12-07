<?php

use Mazvis\ProductsParser\ProductsParser;

class BaseController extends Controller
{
    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.masterOld';

    /**
	 * Setup the layout used by the controller.s
	 *
	 * @return void
	 */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
            $this->layout->content = '';
            $this->layout->bodyClass = '';
            $this->layout->title = 'Prekių paieška';

            //get all existing categories from database
            $existingCategories = ProductsParser::getExistingCategories();
            $this->layout->existingCategories = json_decode($existingCategories);

            //get all existing countries from database
            $existingCountries = ProductsParser::getExistingCountries();
            $this->layout->existingCountries = json_decode($existingCountries);

            //get all existing providers from database
            $existingProviders = ProductsParser::getExistingProviders();
            $this->layout->existingProviders = json_decode($existingProviders);
        }
    }
}

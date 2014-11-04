<?php

use Mazvis\ProductsParser\ProductsParser;

class BaseController extends Controller
{
    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.master';

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
            $this->layout->content = '';
            $this->layout->bodyClass = '';
            $this->layout->title = 'Product search';

            //get all products from database
            $this->layout->existingCategories = ProductsParser::getExistingCategories();
        }
	}

}

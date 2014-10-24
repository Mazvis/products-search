<?php

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $this->call('ProductsTableSeeder');

        $this->command->info('Products table seeded!');
	}
}

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::create(array(
            'description' => 'Redwood',
            'deeplink'    => 'www.gmail.com'
        ));

        $product = new Product;
        $product->description = 'Super Cool';
        $product->deeplink    = 'nevermind';
        $product->save();
    }
}
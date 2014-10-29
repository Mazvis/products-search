<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->string('deepLink')->nullable();
            $table->string('country')->nullable();
            $table->double('originalPrice')->nullable();
            $table->string('originalCurrency')->nullable();
            $table->double('convertedPrice')->nullable();
            $table->string('convertedCurrency')->nullable();
            $table->integer('timestamp');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }

}
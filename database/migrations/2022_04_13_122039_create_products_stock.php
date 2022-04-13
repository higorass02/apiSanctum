<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity')->nullable(false);
            $table->integer('product_stock')->unsigned();
            $table->timestamps();

            $table->foreign('product_stock')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_stock');
    }
}

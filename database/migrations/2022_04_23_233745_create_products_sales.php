<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('dt_expired')->nullable(true);
            $table->boolean('status')->nullable(false);
            $table->integer('qtd')->nullable(false);
            $table->integer('product_sale')->unsigned()->nullable(false);
            $table->timestamps();

            $table->foreign('product_sale')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_sales');
    }
}

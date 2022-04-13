<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description',2500);
            $table->string('branch');
            $table->string('model');
            $table->string('type_capacity');
            $table->string('value_capacity');
            $table->string('validity');
            $table->float('price');
            $table->boolean('star');
            $table->boolean('status');
            $table->integer('category_product')->unsigned();
            $table->timestamps();

            $table->foreign('category_product')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}

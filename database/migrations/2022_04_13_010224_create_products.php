<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable(false);
            $table->string('description',2500)->nullable(false);;
            $table->string('branch')->nullable();
            $table->string('model')->nullable();
            $table->integer('type_capacity')->nullable();
            $table->string('value_capacity')->nullable();
            $table->dateTime('validity')->nullable();
            $table->float('price')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('star')->nullable();
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
        Schema::dropIfExists('products');
    }
}

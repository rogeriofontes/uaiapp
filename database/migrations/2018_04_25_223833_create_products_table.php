<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
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
            $table->string('name');
            $table->integer('product_sub_category_id')->unsigned();
            $table->float('price', 10, 2);
            $table->longtext('content');
            $table->enum('status', ['0', '1'])->default('1');
            $table->enum('type', ['L', 'A'])->default('A');
            $table->integer('person_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_sub_category_id')->references('id')->on('product_sub_categories');
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
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

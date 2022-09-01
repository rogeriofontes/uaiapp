<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductHasInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_has_interests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_app_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_app_id')->references('id')->on('user_apps')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_has_interests');
    }
}

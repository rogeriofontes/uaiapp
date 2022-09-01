<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code_pagseguro')->nullable();
            $table->datetime('date_pagseguro')->nullable();
            $table->string('status', 50)->default('PROCESSANDO'); 
            $table->string('link_boleto')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->integer('plan_id')->unsigned();
            $table->integer('user_app_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
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
        Schema::dropIfExists('checkouts');
    }
}

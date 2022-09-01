<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('menu');
            $table->string('icon');
            $table->string('route');
            $table->enum('show', ['0', '1']);
            $table->integer('menu_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softdeletes();
            $table->foreign('menu_id')
                  ->references('id')->on('menus')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}

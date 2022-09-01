<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('title');
            $table->string('subtitle');
            $table->longtext('content');
            $table->integer('news_category_id')->unsigned();
            $table->integer('media_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('media_id')->references('id')->on('media');
            $table->foreign('news_category_id')->references('id')->on('news_categories');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}

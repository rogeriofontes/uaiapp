<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationHasFcmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_has_fcms', function (Blueprint $table) {
            $table->integer('fcm_id')->unsigned();
            $table->integer('notification_id')->unsigned();
            $table->enum('visualized', ['0', '1']);

            $table->foreign('fcm_id')->references('id')->on('fcms')->onDelete('cascade');
            $table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_has_fcms');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('birthday')->nullable();
            $table->enum('type_person', ['J', 'F']);
            $table->string('cpf_cnpj', 20)->nullable();
            $table->string('ie')->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('media_id')->unsigned()->nullable();
            $table->integer('role_id')->unsigned()->nullable();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('media_id')->references('id')->on('media');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}

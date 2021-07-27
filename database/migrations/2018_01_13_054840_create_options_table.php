<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
         $table->increments('id');
         $table->string('logo')->nullable();
         $table->string('favicon')->nullable();
         $table->string('title')->nullable();
         $table->string('phone')->nullable();
         $table->string('email')->nullable();
         $table->string('address')->nullable();
         $table->string('copyright')->nullable();
         $table->string('facebook')->nullable();
         $table->string('youtube')->nullable();
         $table->string('google')->nullable();
         $table->string('twitter')->nullable();
         $table->string('instagram')->nullable();
         $table->timestamps();
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrinters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host');
            $table->string('name');
            $table->integer('state');
            $table->integer('tool0_temp');
            $table->integer('bed_temp');
            $table->integer('progress');
            $table->integer('elapsed_time')->nullable();
            $table->integer('aprox_time')->nullable();
            $table->integer('estimated_time')->nullable();
            $table->integer('consecutive_errors');
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
        Schema::drop('printers');
    }
}

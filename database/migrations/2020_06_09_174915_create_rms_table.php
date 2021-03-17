<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value');
            $table->string('meta_data')->nullable();
            $table->string('meta_description')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('order')->nullable();
            $table->tinyInteger('is_customized')->default(0)->comment='0=no,1=yes';
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
        Schema::dropIfExists('rms');
    }
}

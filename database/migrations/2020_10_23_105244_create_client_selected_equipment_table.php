<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientSelectedEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_selected_equipment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('equipment_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->string('unique_id')->nullable();
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
        Schema::dropIfExists('client_selected_equipment');
    }
}

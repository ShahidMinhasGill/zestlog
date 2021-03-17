<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeleteOrEditBlockSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delete_or_edit_block_slots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('block_time_slot_id')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->integer('repeat_id')->nullable();
            $table->integer('day_id')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('edit_or_delete')->default(0)->comment='0=edit,1=delete';
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
        Schema::dropIfExists('delete_or_edit_block_slots');
    }
}

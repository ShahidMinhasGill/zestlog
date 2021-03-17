<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payout_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->date('date_of_transfer')->nullable();
            $table->double('amount')->nullable();
            $table->string('transfer_to')->nullable();
            $table->date('earning_month')->nullable();
            $table->string('transfer_id')->nullable();
            $table->string('destination_id')->nullable();
            $table->string('currency')->nullable();
            $table->mediumText('object')->nullable();
            $table->string('week_plan_id')->nullable();
            $table->string('booking_id')->nullable();
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
        Schema::dropIfExists('payout_histories');
    }
}

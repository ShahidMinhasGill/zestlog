<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmedAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmed_amounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->nullable();
            $table->double('amount')->nullable();
            $table->dateTime('payout_date')->nullable();
            $table->date('payout_month')->nullable();
            $table->integer('payout_month_number')->nullable(); // add one in current;
            $table->integer('payout_year_number')->nullable(); // add one in current;
            $table->bigInteger('client_week_plan_id')->nullable();
            $table->bigInteger('booking_id')->nullable();
            $table->tinyInteger('is_confirmed')->default(0)->comment = '0=no,1=yes';
            $table->tinyInteger('is_paid_to_client')->default(0)->comment = '0=no,1=yes';
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
        Schema::dropIfExists('confirmed_amounts');
    }
}

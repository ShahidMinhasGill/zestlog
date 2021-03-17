<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_id');
            $table->bigInteger('client_id');
            $table->bigInteger('user_id');
            $table->integer('service_id');
            $table->string('start_time');
            $table->string('end_time');
            $table->integer('week_id')->nullable();
            $table->integer('year')->nullable();
            $table->date('booking_date');
            $table->bigInteger('training_session_location_id')->nullable();
            $table->tinyInteger('is_payment')->default(0)->comment='0=unpaid,1=paid,2=refund';
            $table->tinyInteger('is_confirmed')->default(2)->comment='0=no,1=yes,2=pending';
            $table->dateTime('payout_date')->nullable(); // add one in current;
            $table->date('payout_month')->nullable(); // add one in current;
            $table->integer('payout_month_number')->nullable(); // add one in current;
            $table->integer('payout_year_number')->nullable(); // add one in current;
            $table->tinyInteger('status')->default(0)->comment='0=waiting,1=active,2=rejected';
            $table->double('amount')->default(0);
            $table->tinyInteger('is_paid_to_client')->default(0)->comment='0=no,1=yes';
            $table->string('reference_number')->nullable();

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
        Schema::dropIfExists('bookings');
    }
}

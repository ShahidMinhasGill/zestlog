<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientWeekPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_week_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->integer('service_id')->default(1);
            $table->string('unique_id')->nullable();
            $table->bigInteger('client_plan_id')->nullable();
            $table->integer('week_id')->nullable();
            $table->string('year')->nullable();
            $table->integer('week_count')->nullable();
            $table->tinyInteger('is_new')->default(0)->comment='0=no,1=yes';
            $table->tinyInteger('is_publish')->default(0)->comment='0=no,1=yes';
            $table->tinyInteger('is_confirmed')->default(2)->comment='0=no,1=yes,2=pending';
            $table->dateTime('payout_date')->nullable(); // add one in current;
            $table->date('payout_month')->nullable(); // add one in current;
            $table->integer('payout_month_number')->nullable(); // add one in current;
            $table->integer('payout_year_number')->nullable(); // add one in current;
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
        Schema::dropIfExists('client_week_plans');
    }
}

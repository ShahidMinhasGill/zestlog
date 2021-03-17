<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_id')->unique();
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->tinyInteger('is_payment')->default(0)->comment = '0=unpaid,1=paid,2=refund';
            $table->tinyInteger('status')->default(0)->comment = '0=waiting,1=active,2=rejected';
            $table->double('total_price')->default(0);
            $table->double('service_fee')->default(0); // from endUser service fee
            $table->double('service_fee_from_coach')->default(0); // from coach
            $table->double('total_service_fee')->default(0);
            $table->double('total_amount')->default(0);
            $table->double('client_f_amount')->default(0);
            $table->double('Training_Program_amount')->default(0);
            $table->double('Online_Coaching_amount')->default(0);
            $table->double('Personal_Training_amount')->default(0);
            $table->double('earning_week_program')->default(0);
            $table->double('earning_oc_session')->default(0);
            $table->double('earning_pt_session')->default(0);
            $table->double('f_tp_amount')->default(0);
            $table->double('f_oc_amount')->default(0);
            $table->double('f_pt_amount')->default(0);
            $table->string('reference_number')->nullable();
            $table->string('counter')->nullable();
            $table->timestamp('starting_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('charge_id')->nullable();
            $table->tinyInteger('is_refund')->default(0)->comment = '0=no,1=yes';
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
        Schema::dropIfExists('final_payments');
    }
}

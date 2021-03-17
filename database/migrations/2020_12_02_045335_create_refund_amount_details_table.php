<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundAmountDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_amount_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('strip_id');
            $table->string('unique_id')->nullable();
            $table->string('object')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('balance_transaction')->nullable();
            $table->string('charge')->nullable();
            $table->string('created')->nullable();
            $table->string('currency')->nullable();
            $table->string('metadata')->nullable();
            $table->string('payment_intent')->nullable();
            $table->string('reason')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('source_transfer_reversal')->nullable();
            $table->string('status')->nullable();
            $table->string('transfer_reversal')->nullable();
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
        Schema::dropIfExists('refund_amount_details');
    }
}

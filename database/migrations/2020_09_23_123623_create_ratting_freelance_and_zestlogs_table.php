<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRattingFreelanceAndZestlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratting_freelance_and_zestlogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->integer('private_review_categories_coach_id')->nullable();
            $table->integer('private_review_categories_zestlog_id')->nullable();
            $table->tinyInteger('star_coach_and_program')->nullable();
            $table->mediumText('experience_about_coach')->nullable();
            $table->mediumText('experience_zestlog')->nullable();
            $table->tinyInteger('star_zestlog')->nullable();
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
        Schema::dropIfExists('ratting_freelance_and_zestlogs');
    }
}

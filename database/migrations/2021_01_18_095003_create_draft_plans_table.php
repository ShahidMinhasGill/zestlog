<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_plans', function (Blueprint $table) {
            $table->bigIncrements('auto_increment_id');
            $table->bigInteger('id')->nullable();
            $table->string('title');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('day_plan_id')->default(1);
            $table->integer('goal_id');
            $table->integer('training_day_id');
            $table->integer('training_age_id');
            $table->integer('age_category_id');
            $table->string('duration')->default('one week')->nullable();
            $table->enum('access_type', ['private', 'public']);
            $table->mediumText('description')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->enum('status', ['0', '1', '2'])->comment='0=blocked,1=active';
            $table->tinyInteger('is_completed')->default(0);
            $table->tinyInteger('plan_day_id')->default(0);
            $table->tinyInteger('old_plan_id')->default(0);
            $table->tinyInteger('plan_type')->default(0)->comment='0=week-plan,1=day-plan';
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('draft_plans');
    }
}

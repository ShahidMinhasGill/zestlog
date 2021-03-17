<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAssessmentQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `assessments_questions` ADD `que_type` TINYINT(3) NOT NULL DEFAULT '1' COMMENT '1=yes/no 2=yes/no with comment 3=comment' AFTER `title`");
        DB::statement("UPDATE `assessments_questions` SET `que_type` = '2' WHERE `assessments_questions`.`parent_id` = 9");  
        DB::statement("UPDATE `assessments_questions` SET `que_type` = '2' WHERE `assessments_questions`.`id` = 21");
        DB::statement("UPDATE `assessments_questions` SET `que_type` = '2' WHERE `assessments_questions`.`id` = 22");
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `assessments_questions` DROP `que_type`");

    }
}

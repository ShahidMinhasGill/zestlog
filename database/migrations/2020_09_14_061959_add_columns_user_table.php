<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddColumnsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `users` ADD `privacy_type` VARCHAR(3) NOT NULL DEFAULT '1' COMMENT '1=public 2=private' AFTER `remember_token`, ADD `chat_status` VARCHAR(4) NOT NULL DEFAULT '1' COMMENT '1=public 2=only followers 3=no one' AFTER `privacy_type`, ADD `profile_description` TEXT NULL DEFAULT NULL AFTER `chat_status`
        ;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * 
     */
    public function down()
    {

       DB::statement('ALTER TABLE `users` DROP `privacy_type`, DROP `chat_status`,DROP `profile_description`');


        //
    }
}

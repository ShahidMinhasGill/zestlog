<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('user_name')->unique();
            $table->integer('specialization_id')->nullable();
            $table->string('title')->nullable(); // Freelance Specialist Title
            $table->tinyInteger('user_type')->default(0)->comment='0=freelance,1=admin,2=mobile-users';
            $table->string('display_name')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
            $table->date('birthday')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('temp_mobile_number')->nullable();
            $table->string('temp_email_address')->nullable();
            $table->string('extension')->nullable();
            $table->string('address_line_one')->nullable();
            $table->string('address_line_two')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('state')->nullable(); //
            $table->string('country')->nullable();
            $table->string('country_id')->nullable();
            $table->string('device_type')->nullable(); //for example check request came from web or mobile
            $table->string('device_token')->nullable();
            $table->string('otp_code')->nullable();
            $table->dateTime('otp_send_time')->nullable();
            $table->tinyInteger('is_verify')->default(0);
            $table->integer('goal_id')->default(0);
            $table->string('height')->default(0);
            $table->string('weight')->default(0);
            $table->string('bmi')->nullable();         // Body Mass Index
            $table->string('height_units')->default(0);
            $table->string('weight_units')->default('kg');
            $table->string('waist')->nullable();
            $table->string('waist_units', 100)->nullable();
            $table->integer('training_age_id')->default(0);
            $table->mediumText('more_info')->nullable();
            $table->mediumText('additional_details')->nullable();
            $table->string('profile_pic_upload')->nullable();
            $table->tinyInteger('active_status')->default(0);
            $table->tinyInteger('status')->default(1)->comment='0=blocked,1=active,2=deactivated';
            $table->tinyInteger('client_status')->default(0)->comment='0=waiting,1=active,2=archived';
            $table->tinyInteger('is_coach_channel')->default(0)->comment='0=no,1=yes';
            $table->tinyInteger('is_education_verified')->default(0)->comment='0=no,1=yes';
            $table->tinyInteger('is_3i_partner')->default(0)->comment='0=no,1=yes';
            $table->tinyInteger('is_username_public')->default(0)->comment='0=no,1=yes';
            $table->tinyInteger('is_identity_verified')->default(2)->comment='0=pending,1=verified,2=not verified';
            $table->dateTime('eduction_certificate_upload_date')->nullable();
            $table->double('coach_score')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_log_created_at')->nullable();
            $table->bigInteger('total_bookings')->default(0);
            $table->bigInteger('total_rejected_bookings')->default(0);
            $table->integer('time_spent')->nullable();
            $table->tinyInteger('is_new')->default(1);
            $table->tinyInteger('is_client_show')->default(0);
            $table->double('client_g_value')->default(1);
            $table->double('total_earning')->default(0);
            $table->double('total_earning_with_fee')->default(0);
            $table->double('total_spending')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->mediumText('introduction')->nullable();
            $table->string('s_a_id')->default(0);
            $table->string('postal_code')->nullable();
            $table->tinyInteger('coach_popup_status')->default(0)->comment='0=no,1=yes';
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

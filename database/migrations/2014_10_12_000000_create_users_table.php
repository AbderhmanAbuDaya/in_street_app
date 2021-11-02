<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('type_id')->constrained('types')->cascadeOnDelete();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique();
            $table->string('image')->nullable();
            $table->string('password');
            /*
                avatar
                status
                // emergency_phone
                address
                // emergency_visibility
            */
            /*
                license_number
                license_issue_date
                license_expiry_date
                vehicle_type
                vehicle_model
                car_panel_number_int
                driver_license_image
                vehicle_license_image
                vehicle_insurance_image
                vehicle_front_image
                vehicle_back_image
                parent_operation_path
            */


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

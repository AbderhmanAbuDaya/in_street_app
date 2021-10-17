<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('license_number');
            $table->date('license_issue_date');
            $table->date('license_expiry_date');
            $table->foreignId('vehicle_type')->constrained('lookup_values')->comment('small => 4 & large=>7');
            $table->foreignId('vehicle_model')->constrained('lookup_values');
            $table->integer('car_panel_number_int');
            $table->string('driver_license_image');
            $table->string('vehicle_license_image');
            $table->string('vehicle_insurance_image');
            $table->string('vehicle_front_image');
            $table->string('vehicle_back_image');
            $table->foreignId('parent_operation_path')->constrained('parent_operation_paths')->cascadeOnDelete();
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
        Schema::dropIfExists('drivers');
    }
}

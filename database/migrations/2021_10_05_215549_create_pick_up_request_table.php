<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickUpRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pick_up_requests', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('trip_id')->nullable()->constrained('trips')->cascadeOnDelete();
            $table->foreignId('operation_path_id')->constrained('operation_paths')->cascadeOnDelete();
            $table->foreignId('status')->constrained('lookup_values');
            $table->boolean('is_custom_location')->default(false);
            $table->string('current_location')->nullable();
            $table->integer('num_seats');
            $table->timestamp('estimated_driver_arrival_time')->nullable();
            $table->timestamp('estimated_arrival_time')->nullable();
            $table->timestamp('actual_arrival_time')->nullable();
            $table->double('latitude');
            $table->double('longitude');
            $table->double('actual_cost')->nullable();
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
        Schema::dropIfExists('pick_up_request');
    }
}

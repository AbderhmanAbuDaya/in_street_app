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
            $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
            $table->foreignId('operation_path_id')->constrained('operation_paths')->cascadeOnDelete();
            $table->boolean('status')->default(0);
            $table->integer('num_seats');
            $table->integer('estimated_driver_arrival_time');
            $table->integer('estimated_arrival_time');
            $table->integer('actual_arrival_time');
            $table->double('latitude');
            $table->double('longitude');
            $table->double('actual_cost');
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

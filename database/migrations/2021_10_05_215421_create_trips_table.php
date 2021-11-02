<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drive_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('operation_path_id')->nullable()->constrained('operation_paths')->cascadeOnDelete();
            $table->foreignId('status')->constrained('lookup_values');
            $table->date('dateTime');
            $table->boolean('is_custom_location')->default(false);
            $table->string('current_location')->nullable();
            $table->integer('num_available_seats');
            $table->double('latitude');
            $table->double('longitude');
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
        Schema::dropIfExists('trips');
    }
}

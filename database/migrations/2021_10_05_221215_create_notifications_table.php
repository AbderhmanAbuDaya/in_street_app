<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('request_id')->constrained('pick_up_requests')->cascadeOnDelete();
            $table->text('notification_ar');
            $table->text('notification_en');
            $table->boolean('is_on_screen');
            $table->boolean('is_sent');
            $table->boolean('is_opened');
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
        Schema::dropIfExists('notifications');
    }
}

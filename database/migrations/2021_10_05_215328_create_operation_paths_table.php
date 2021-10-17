<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationPathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_paths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_operation_path_id')->constrained('parent_operation_paths')->cascadeOnDelete();
            $table->integer('source');
//            $table->integer('source_type');
            $table->double('destination');
//            $table->double('destination_type');
            $table->double('cost');
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
        Schema::dropIfExists('operation_paths');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->references('id')->on('users');
            $table->foreignId('assigned_to_id')->references('id')->on('users');
            $table->string('name');
            $table->string('description');
            $table->integer('group_id');
            $table->timestamp('deadline');
            $table->boolean('is_completed')->default(0);
            $table->integer('priority_id')->default(1);
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
        Schema::dropIfExists('tasks');
    }
}

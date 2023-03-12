<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('task_name');
            $table->string('task_description');
            $table->string('task_assigned');
            $table->enum('task_Status',['Pending', 'Cancel', 'Start','Wait','Finish'])->default('Pending');
            $table->string('start_date');
            $table->string('end_date');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
};

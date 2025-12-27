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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time')->nullable();
            $table->integer('office_hours')->default(8);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unique(['branch_id', 'date']);
            $table->boolean('is_locked')->default(0);


            $table->timestamps();
        });


        Schema::create('attendance_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_id');
            $table->date('date');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('salary_type_id');
            $table->unsignedBigInteger('job_id');
            $table->string('status');
            $table->integer('office_hours')->nullable();
            $table->decimal('worked_hours', 5, 2)->nullable();
            $table->decimal('overtime', 6,2)->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->boolean('is_locked')->default(0);

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
        Schema::dropIfExists('attendance_details');
        Schema::dropIfExists('attendances');
    }
};

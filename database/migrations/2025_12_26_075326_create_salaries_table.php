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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->date('salary_month');
            $table->unsignedTinyInteger('total_days');

            $table->unsignedTinyInteger('working_days');
            $table->decimal('office_hours_per_day',15,2);
            $table->decimal('overtime_hourly_rate',15,2);
            $table->decimal('basic_hourly_rate',15,2);

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unique(['branch_id', 'salary_month']);
            $table->boolean('is_locked')->default(0);
            $table->timestamps();
        });

        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('salary_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('job_title_id');

            // Basic salary
            $table->decimal('basic_salary', 15, 2);
            $table->decimal('basic_hourly_rate', 15, 2);
            $table->decimal('basic_hours_worked', 15, 2);
            $table->decimal('basic_total', 15, 2);

            // Overtime
            $table->decimal('overtime_hourly_rate', 15, 2);
            $table->decimal('overtime_hours', 15, 2);
            $table->decimal('overtime_total', 15, 2);

            // Final amounts
            $table->decimal('gross_salary', 15, 2);
            $table->decimal('advance_paid', 15, 2);
            $table->decimal('net_salary', 15, 2);

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
        Schema::dropIfExists('salary_details');
        Schema::dropIfExists('salaries');
    }
};

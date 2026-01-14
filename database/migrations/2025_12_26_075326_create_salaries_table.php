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
            $table->decimal('office_hours_per_day', 4, 2);

            $table->decimal('overtime_working_day_rate', 15, 2);
            $table->decimal('overtime_holiday_rate', 15, 2);

            $table->foreignId('user_id')->nullable();
            $table->foreignId('branch_id')->nullable();

            $table->boolean('is_locked')->default(false);

            $table->unique(['branch_id', 'salary_month']);
            $table->timestamps();
        });

        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('salary_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('job_title_id')->nullable();
            $table->unsignedBigInteger('salary_type_id')->nullable();

            // Salary
            $table->decimal('salary_base_amount', 15, 2)->nullable();
            $table->decimal('salary_base_per_day', 15, 2)->nullable();
            $table->string('salary_base_type')->nullable();

            // Basic
            $table->decimal('basic_worked_hours', 15, 2)->nullable();
            $table->decimal('basic_hourly_rate', 15, 4)->nullable();
            $table->decimal('basic_total', 15, 2)->nullable();

            // Overtime
            $table->decimal('overtime_hours', 15, 6)->nullable();
            $table->decimal('overtime_hourly_rate', 15, 4)->nullable();
            $table->decimal('overtime_total', 15, 2)->nullable();

            // Holiday Overtime
            $table->decimal('holiday_overtime_hourly_rate', 15, 6)->nullable();
            $table->decimal('holiday_overtime_hours', 15, 2)->nullable();
            $table->decimal('holiday_overtime_total', 15, 2)->nullable();

            // Final
            $table->decimal('gross_salary', 15, 2)->nullable();
            $table->decimal('advance_paid', 15, 2)->nullable();
            $table->decimal('net_salary', 15, 2)->nullable();

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

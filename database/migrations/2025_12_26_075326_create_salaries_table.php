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
            $table->integer('month_days');
            $table->timestamps();
        });

        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('salary_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('job_title_id');

            // Basic salary
            $table->decimal('basic_salary_amount', 15, 2);
            $table->decimal('basic_hourly_rate', 15, 2);
            $table->decimal('basic_worked_hours', 15, 2);
            $table->decimal('basic_total_amount', 15, 2);

            // Overtime
            $table->decimal('overtime_hourly_rate', 15, 2);
            $table->decimal('overtime_hours', 15, 2);
            $table->decimal('overtime_total_amount', 15, 2);

            // Final amounts
            $table->decimal('gross_salary_amount', 15, 2);
            $table->decimal('advance_amount', 15, 2);
            $table->decimal('net_salary_amount', 15, 2);

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

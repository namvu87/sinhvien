<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('medical_records')) {
            Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_number', 50)->unique();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->date('visit_date');
            $table->time('visit_time');

            // Vital signs
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('temperature', 4, 2)->nullable();
            $table->integer('blood_pressure_systolic')->nullable();
            $table->integer('blood_pressure_diastolic')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();

            // Clinical info
            $table->text('chief_complaint');
            $table->text('symptoms')->nullable();
            $table->text('diagnosis');
            $table->text('treatment_plan')->nullable();
            $table->text('lab_tests_ordered')->nullable();
            $table->text('imaging_ordered')->nullable();
            $table->text('follow_up_instructions')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->text('notes')->nullable();

            $table->enum('status', ['draft', 'completed', 'archived'])->default('draft');

            $table->timestamps();

            $table->index('record_number', 'idx_record_number');
            $table->index('patient_id', 'idx_patient_id');
            $table->index('doctor_id', 'idx_doctor_id');
            $table->index('appointment_id', 'idx_appointment_id');
            $table->index('visit_date', 'idx_visit_date');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};

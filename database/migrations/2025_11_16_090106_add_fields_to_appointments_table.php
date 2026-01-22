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
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'appointment_number')) {
                $table->string('appointment_number', 50)->unique()->after('id');
            }
            if (!Schema::hasColumn('appointments', 'patient_id')) {
                $table->unsignedBigInteger('patient_id')->nullable()->after('appointment_number');
            }
            if (!Schema::hasColumn('appointments', 'doctor_id')) {
                $table->unsignedBigInteger('doctor_id')->nullable()->after('patient_id');
            }
            if (!Schema::hasColumn('appointments', 'appointment_date')) {
                $table->date('appointment_date')->nullable()->after('doctor_id');
            }
            if (!Schema::hasColumn('appointments', 'appointment_time')) {
                $table->time('appointment_time')->nullable()->after('appointment_date');
            }
            if (!Schema::hasColumn('appointments', 'slot_duration')) {
                $table->integer('slot_duration')->default(30)->after('appointment_time');
            }
            if (!Schema::hasColumn('appointments', 'reason')) {
                $table->text('reason')->nullable()->after('slot_duration');
            }
            if (!Schema::hasColumn('appointments', 'status')) {
                $table->enum('status', ['scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show'])
                    ->default('scheduled')->after('reason');
            }
            if (!Schema::hasColumn('appointments', 'priority')) {
                $table->enum('priority', ['normal', 'urgent', 'emergency'])->default('normal')->after('status');
            }
            if (!Schema::hasColumn('appointments', 'notes')) {
                $table->text('notes')->nullable()->after('priority');
            }
            if (!Schema::hasColumn('appointments', 'cancelled_reason')) {
                $table->text('cancelled_reason')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('appointments', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable()->after('cancelled_reason');
            }
            if (!Schema::hasColumn('appointments', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable()->after('cancelled_at');
            }
            if (!Schema::hasColumn('appointments', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('confirmed_at');
            }
            if (!Schema::hasColumn('appointments', 'reminder_sent_at')) {
                $table->timestamp('reminder_sent_at')->nullable()->after('completed_at');
            }
            if (!Schema::hasColumn('appointments', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('reminder_sent_at');
            }

            // Indexes & FKs (soft, avoid failure if missing referenced tables)
            if (!Schema::hasColumn('appointments', 'patient_id')) {
                // handled above
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $columns = [
                'appointment_number','patient_id','doctor_id','appointment_date','appointment_time',
                'slot_duration','reason','status','priority','notes','cancelled_reason','cancelled_at',
                'confirmed_at','completed_at','reminder_sent_at','created_by',
            ];
            foreach ($columns as $col) {
                if (Schema::hasColumn('appointments', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};

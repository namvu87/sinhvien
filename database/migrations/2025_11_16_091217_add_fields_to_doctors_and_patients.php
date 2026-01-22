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
        Schema::table('doctors', function (Blueprint $table) {
            if (!Schema::hasColumn('doctors', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('doctors', 'specialty')) {
                $table->string('specialty')->nullable()->after('name');
            }
            if (!Schema::hasColumn('doctors', 'license_number')) {
                $table->string('license_number')->nullable()->after('specialty');
            }
            if (!Schema::hasColumn('doctors', 'phone')) {
                $table->string('phone')->nullable()->after('license_number');
            }
        });

        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('patients', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('name');
            }
            if (!Schema::hasColumn('patients', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('patients', 'phone')) {
                $table->string('phone')->nullable()->after('gender');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            foreach (['name','specialty','license_number','phone'] as $col) {
                if (Schema::hasColumn('doctors', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
        Schema::table('patients', function (Blueprint $table) {
            foreach (['name','date_of_birth','gender','phone'] as $col) {
                if (Schema::hasColumn('patients', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};

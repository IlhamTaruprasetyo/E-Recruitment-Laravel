<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('department_test', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->unique(['test_id', 'department_id']);
            $table->timestamps();
        });

        // Migrasikan data test yang sudah memiliki department_id lama ke tabel pivot
        if (Schema::hasColumn('tests', 'department_id')) {
            $existingTests = DB::table('tests')->whereNotNull('department_id')->get();
            foreach ($existingTests as $test) {
                // Pastikan departemen masih ada sebelum insert
                $deptExists = DB::table('departments')->where('id', $test->department_id)->exists();
                if ($deptExists) {
                    DB::table('department_test')->insertOrIgnore([
                        'test_id' => $test->id,
                        'department_id' => $test->department_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_test');
    }
};

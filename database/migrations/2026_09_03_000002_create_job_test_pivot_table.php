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
        Schema::create('job_test', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->unique(['test_id', 'job_id']);
            $table->timestamps();
        });

        // Migrasikan data test yang sudah memiliki job_id lama ke tabel pivot
        if (Schema::hasColumn('tests', 'job_id')) {
            $existingTests = DB::table('tests')->whereNotNull('job_id')->get();
            foreach ($existingTests as $test) {
                $jobExists = DB::table('jobs')->where('id', $test->job_id)->exists();
                if ($jobExists) {
                    DB::table('job_test')->insertOrIgnore([
                        'test_id' => $test->id,
                        'job_id' => $test->job_id,
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
        Schema::dropIfExists('job_test');
    }
};

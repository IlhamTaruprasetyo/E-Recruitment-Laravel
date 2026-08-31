<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->string('participant_name')->nullable()->after('attempt_type');
            $table->integer('participant_age')->nullable()->after('participant_name');
            $table->enum('participant_gender', ['male', 'female'])->nullable()->after('participant_age');
            $table->date('test_date')->nullable()->after('participant_gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->dropColumn([
                'participant_name',
                'participant_age',
                'participant_gender',
                'test_date',
            ]);
        });
    }
};

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
        Schema::table('applicant_profile', function (Blueprint $table) {
            $table->integer('child_sequence')->nullable()->after('npwp');
            $table->integer('total_siblings')->nullable()->after('child_sequence');
            $table->enum('marital_status', ['lajang', 'menikah', 'bercerai'])->nullable()->after('total_siblings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_profile', function (Blueprint $table) {
            $table->dropColumn(['child_sequence', 'total_siblings', 'marital_status']);
        });
    }
};

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
        Schema::table('test_answers', function (Blueprint $table) {
            $table->text('attachment_url')->nullable()->after('essay_answer');
            $table->string('attachment_name')->nullable()->after('attachment_url');
            $table->unsignedBigInteger('attachment_size')->nullable()->after('attachment_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_answers', function (Blueprint $table) {
            $table->dropColumn(['attachment_url', 'attachment_name', 'attachment_size']);
        });
    }
};

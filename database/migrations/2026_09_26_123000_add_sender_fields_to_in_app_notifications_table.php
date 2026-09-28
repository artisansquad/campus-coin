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
        Schema::table('in_app_notifications', function (Blueprint $table) {
            $table->string('sender_name')->nullable()->after('title');
            $table->string('sender_email')->nullable()->after('sender_name');
            $table->foreignId('contact_message_id')->nullable()->after('sender_email')->constrained('contact_messages')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('in_app_notifications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('contact_message_id');
            $table->dropColumn(['sender_name', 'sender_email']);
        });
    }
};

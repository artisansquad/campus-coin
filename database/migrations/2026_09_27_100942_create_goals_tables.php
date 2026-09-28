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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('category')->nullable()->default('Academic');
            $table->decimal('target_amount', 12, 2);
            $table->decimal('current_amount', 12, 2)->default(0.00);
            $table->unsignedInteger('duration_months')->default(1);
            $table->date('target_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('status', 30)->default('in_progress');
            $table->timestamps();
        });

        Schema::create('goal_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('goals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type', 20); // 'deposit' or 'withdraw'
            $table->decimal('amount', 12, 2);
            $table->text('notes')->nullable();
            $table->date('transaction_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_transactions');
        Schema::dropIfExists('goals');
    }
};

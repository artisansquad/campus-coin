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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->string('description');
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_frequency')->nullable(); // 'weekly', 'monthly'
            $table->foreignId('ai_suggested_category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->boolean('is_flagged')->default(false); // unusually large or duplicate
            $table->string('flag_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

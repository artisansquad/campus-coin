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
        Schema::create('user_dashboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('month', 7);
            $table->decimal('net_balance', 12, 2)->default(0);
            $table->decimal('monthly_income', 12, 2)->default(0);
            $table->decimal('monthly_expense', 12, 2)->default(0);
            $table->decimal('monthly_savings_goal', 12, 2)->default(0);
            $table->decimal('saving_rate', 5, 2)->default(0);
            $table->string('top_category')->nullable();
            $table->decimal('top_category_percentage', 5, 2)->default(0);
            $table->json('summary_json')->nullable();
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_dashboards');
    }
};

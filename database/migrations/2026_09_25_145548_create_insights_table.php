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
        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('month', 7); // Format: 'YYYY-MM'
            $table->text('summary_text');
            $table->string('flagged_category')->nullable();
            $table->decimal('growth_percentage', 6, 2)->nullable();
            $table->text('tip_text')->nullable();
            $table->boolean('is_bookmarked')->default(false);
            $table->dateTime('generated_at');
            $table->timestamps();

            $table->index(['user_id', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insights');
    }
};

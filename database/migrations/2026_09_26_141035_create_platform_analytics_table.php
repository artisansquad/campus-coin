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
        Schema::create('platform_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('metric_key');
            $table->string('label');
            $table->string('group')->default('kpi');
            $table->string('period')->default('12m');
            $table->decimal('value', 15, 2)->default(0);
            $table->decimal('change', 10, 2)->default(0);
            $table->string('unit')->nullable();
            $table->string('suffix')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique(['metric_key', 'period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_analytics');
    }
};

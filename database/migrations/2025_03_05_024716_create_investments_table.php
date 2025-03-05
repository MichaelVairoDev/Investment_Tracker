<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->string('symbol', 10);
            $table->string('name');
            $table->enum('type', ['stock', 'crypto', 'bond', 'etf', 'mutual_fund', 'other']);
            $table->decimal('current_price', 20, 2);
            $table->decimal('quantity', 20, 6);
            $table->decimal('current_value', 20, 2);
            $table->decimal('total_invested', 20, 2);
            $table->decimal('profit_loss', 20, 2);
            $table->decimal('profit_loss_percentage', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};

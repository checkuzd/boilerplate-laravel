<?php

declare(strict_types=1);

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->mediumText('description')->nullable();
            $table->smallInteger('status', false, true)->default(1);
            $table->dateTime('available_from')->useCurrent();
            $table->integer('price', false, true);
            $table->integer('old_price', false, true)->nullable();
            $table->integer('stock', false, true);
            $table->smallInteger('stock_alert', false, true)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

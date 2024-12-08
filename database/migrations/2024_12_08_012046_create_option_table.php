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
        Schema::create('option', function (Blueprint $table) {
            $table->id();
            //スタッフ種別
            $table->json('stafftype_list')->nullable();
            //時給 
            $table->json('wage')->nullable();
            // 保険料
            $table->json('insurance_premium')->nullable();
            // 年金
            $table->json('pension')->nullable();
            // マージン計算
            $table->json('margin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option');
    }
};

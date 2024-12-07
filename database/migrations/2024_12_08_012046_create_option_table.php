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
            $table->json('stafftype_list')->default('{}');
            //時給 
            $table->json('wage')->default('{}');
            // 保険料
            $table->json('insurance_premium')->default('{}');
            // 年金
            $table->json('pension')->default('{}');
            // マージン計算
            $table->json('margin')->default('{}');
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

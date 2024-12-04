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
        Schema::create('stafflist', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('email');
            $table->text('stafftype');
            $table->text('furigana');
            $table->text('sex');
            $table->text('postnumber');
            $table->text('address');
            $table->text('train_route');
            $table->text('station');
            $table->text('mynumber');
            $table->boolean('dependent');
            $table->text('dependent_income')->nullable();
            $table->text('dependent_name')->nullable();
            $table->text('dependent_furigana')->nullable();
            $table->text('dependent_sex')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stafflist');
    }
};

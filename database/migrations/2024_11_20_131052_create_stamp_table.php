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
        Schema::create('stamp', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('user_name');
            $table->text('punch_in');
            $table->text('punch_out')->nullable();
            $table->text('break_in')->nullable();
            $table->text('break_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stamp');
    }
};

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
        Schema::create('professor_matter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('matter_id')->constrained()->cascadeOnDelete();
            $table->primary(['professor_id', 'matter_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_matter');
    }
};

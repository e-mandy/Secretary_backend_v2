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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->enum('type_doc', ["Curriculum Vitae", "Diplôme"]);
            $table->string('file_mime_type')->after('type_doc');
            $table->unsignedBigInteger('file_size')->after('file_mime_type');
            $table->string("file_path")->after('label');
            $table->timestamps();
            
            $table->foreignId('professor_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

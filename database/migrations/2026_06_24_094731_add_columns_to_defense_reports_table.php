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
        Schema::table('defense_reports', function (Blueprint $table) {
            $table->enum("filiere", ["Licence", "Master"]);
            $table->enum('option', ["AL", "SRC", "SI", "IA"]);
            $table->renameColumn("label", "theme");
            $table->decimal('note', 4, 2);
            $table->string('defense_report_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('defense_reports', function (Blueprint $table) {
            //
        });
    }
};

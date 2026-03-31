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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('file_mime_type')->after('type_doc');
            $table->unsignedBigInteger('file_size')->after('file_mime_type');
            $table->string("file_path")->after('label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('file_mime_type');
            $table->dropColumn('file_size');
            $table->dropColumn('file_path');
        });
    }
};

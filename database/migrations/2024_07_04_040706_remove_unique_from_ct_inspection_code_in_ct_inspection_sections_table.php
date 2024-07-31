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
        Schema::table('ct_inspection_sections', static function (Blueprint $table) {
            #$table->dropUnique('ct_inspection_sections_ct_inspection_section_code_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ct_inspection_sections', function (Blueprint $table) {
            $table->string('ct_inspection_section_code')->unique()->change();
        });
    }
};

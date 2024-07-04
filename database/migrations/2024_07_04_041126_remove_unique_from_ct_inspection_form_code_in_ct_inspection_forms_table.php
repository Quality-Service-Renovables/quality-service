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
        Schema::table('ct_inspection_forms', static function (Blueprint $table) {
            $table->dropUnique('ct_inspection_forms_ct_inspection_form_code_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ct_inspection_forms', static function (Blueprint $table) {
            $table->string('ct_inspection_form_code')->unique()->change();
        });
    }
};

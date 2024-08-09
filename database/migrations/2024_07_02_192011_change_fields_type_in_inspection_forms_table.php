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
        Schema::table('inspection_forms', function (Blueprint $table) {
            $table->text('inspection_form_value')->change();
            $table->text('inspection_form_comments')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspection_forms', function (Blueprint $table) {
            $table->string('inspection_form_value')->change();
            $table->string('inspection_form_comments')->nullable()->change();
        });
    }
};

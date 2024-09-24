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
        Schema::table('inspection_evidences', function (Blueprint $table) {
            $table->uuid('sync_app_uuid')->nullable()->after('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspection_evidences', function (Blueprint $table) {
            $table->dropColumn('sync_app_uuid');
        });
    }
};

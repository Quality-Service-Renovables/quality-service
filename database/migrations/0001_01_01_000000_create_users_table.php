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
        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('image_profile')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('rol_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('uuid');
            $table->index('client_id');
            //FOREIGN KEYS
            $table->foreign('client_id', 'fk_user_client')
                ->references('client_id')
                ->on('clients');
            $table->foreign('rol_id', 'fk_user_rol')
                ->references('id')
                ->on('roles');
        });

        Schema::create('password_reset_tokens', static function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', static function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

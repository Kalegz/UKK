<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('anonymous');
            $table->string('profile_photo')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Membuat tabel password_reset_tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Membuat tabel sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Membuat tabel students
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->index();
            $table->string('nis')->unique();
            $table->string('class', 50);
            $table->string('major', 50);
            $table->timestamps();
        });

        // Membuat trigger untuk menambahkan data ke tabel students
        // saat ada INSERT pada tabel users dengan role 'student'
        DB::unprepared('
            CREATE TRIGGER after_user_insert
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                IF NEW.role = "student" THEN
                    INSERT INTO students (user_id, nis, class, major, created_at, updated_at)
                    VALUES (NEW.id, CONCAT("NIS-", NEW.id), "Placeholder Class", "Placeholder Major", NOW(), NOW());
                END IF;
            END
        ');
    }

    public function down(): void
    {
        // Menghapus trigger
        DB::unprepared('DROP TRIGGER IF EXISTS after_user_insert');

        // Menghapus tabel
        Schema::dropIfExists('students');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
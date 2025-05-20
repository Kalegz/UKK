// database/migrations/[timestamp]_create_trigger_for_teacher_on_user_insert.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER after_user_insert_teacher
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                IF NEW.role = "teacher" THEN
                    INSERT INTO teachers (user_id, subject, created_at, updated_at)
                    VALUES (NEW.id, "Placeholder Subject", NOW(), NOW());
                END IF;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_user_insert_teacher');
    }
};
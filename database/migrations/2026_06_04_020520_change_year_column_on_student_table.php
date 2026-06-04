<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE student MODIFY year VARCHAR(20) NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE student MODIFY year YEAR NOT NULL');
    }
};

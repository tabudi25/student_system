<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('student', 'profile_image')) {
            Schema::table('student', function (Blueprint $table) {
                $table->string('profile_image')->nullable()->after('student_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('student', 'profile_image')) {
            Schema::table('student', function (Blueprint $table) {
                $table->dropColumn('profile_image');
            });
        }
    }
};

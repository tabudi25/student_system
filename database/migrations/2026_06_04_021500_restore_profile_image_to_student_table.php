<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student', function (Blueprint $table) {
            if (! Schema::hasColumn('student', 'profile_image')) {
                $table->string('profile_image')->nullable()->after('student_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('student', function (Blueprint $table) {
            if (Schema::hasColumn('student', 'profile_image')) {
                $table->dropColumn('profile_image');
            }
        });
    }
};
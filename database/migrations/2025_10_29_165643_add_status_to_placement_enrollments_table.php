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
        Schema::table('placement_enrollments', function (Blueprint $table) {
            if (!Schema::hasColumn('placement_enrollments', 'status')) {
                $table->string('status')->default('pending')->after('amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placement_enrollments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

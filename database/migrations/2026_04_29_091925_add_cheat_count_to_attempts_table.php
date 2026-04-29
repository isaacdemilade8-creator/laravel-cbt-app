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
        if (! Schema::hasColumn('attempts', 'cheat_count')) {
            Schema::table('attempts', function (Blueprint $table) {
                $table->integer('cheat_count')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('attempts', 'cheat_count')) {
            Schema::table('attempts', function (Blueprint $table) {
                $table->dropColumn('cheat_count');
            });
        }
    }
};

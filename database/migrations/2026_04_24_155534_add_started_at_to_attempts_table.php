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
        if (! Schema::hasColumn('attempts', 'started_at')) {
            Schema::table('attempts', function (Blueprint $table) {
                $table->timestamp('started_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('attempts', 'started_at')) {
            Schema::table('attempts', function (Blueprint $table) {
                $table->dropColumn('started_at');
            });
        }
    }
};

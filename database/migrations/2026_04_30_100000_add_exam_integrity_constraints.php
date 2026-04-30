<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attempts', function (Blueprint $table) {
            $table->unique(['user_id', 'exam_id'], 'attempts_user_exam_unique');
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->unique(['attempt_id', 'question_id'], 'answers_attempt_question_unique');
        });
    }

    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropUnique('answers_attempt_question_unique');
        });

        Schema::table('attempts', function (Blueprint $table) {
            $table->dropUnique('attempts_user_exam_unique');
        });
    }
};

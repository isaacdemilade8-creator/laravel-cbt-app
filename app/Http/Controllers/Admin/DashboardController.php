<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalExams = Exam::count();
        $totalAttempts = Attempt::count();

        $averageScore = Attempt::avg('score');

        $recentAttempts = Attempt::with('user', 'exam')
            ->latest()
            ->take(5)
            ->get();

        $flaggedStudents = Attempt::select(
            'user_id',
            DB::raw('SUM(cheat_count) as total_cheat_count'),
            DB::raw('COUNT(CASE WHEN cheat_count > 0 THEN 1 END) as flagged_attempts')
        )
            ->where('cheat_count', '>', 0)
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('total_cheat_count')
            ->get();

        $attemptsPerExam = Attempt::select('exam_id', DB::raw('count(*) as total'))
            ->groupBy('exam_id')
            ->with('exam')
            ->get();

        $avgScorePerExam = Attempt::select('exam_id', DB::raw('avg(score) as avg_score'))
            ->groupBy('exam_id')
            ->with('exam')
            ->get();

        $questionStats = Answer::select(
            'answers.question_id',
            DB::raw('COUNT(*) as total_answers'),
            DB::raw('SUM(CASE WHEN options.is_correct = 1 THEN 1 ELSE 0 END) as correct_answers')
        )
            ->join('options', 'answers.option_id', '=', 'options.id')
            ->groupBy('answers.question_id')
            ->with('question')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalExams',
            'totalAttempts',
            'averageScore',
            'recentAttempts',
            'flaggedStudents',
            'attemptsPerExam',
            'avgScorePerExam',
            'questionStats'
        ));
    }
}

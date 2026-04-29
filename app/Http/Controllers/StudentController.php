<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    public function show($examId)
    {
        $exam = Exam::with('questions.options')->findOrFail($examId);

        $attempt = Attempt::where('user_id', Auth::id())
            ->where('exam_id', $examId)
            ->first();

        if ($attempt) {
            if (! is_null($attempt->score)) {
                return redirect()->route('student.results', $attempt->id);
            }
        } else {
            $attempt = Attempt::create([
                'user_id' => Auth::id(),
                'exam_id' => $examId,
                'started_at' => now(),
            ]);
        }

        return view('student.exam', compact('exam', 'attempt'));
    }

    public function submit(Request $request, $examId)
    {
        $attempt = Attempt::where('user_id', Auth::id())
            ->where('exam_id', $examId)
            ->firstOrFail();

        $exam = Exam::findOrFail($examId);

        $expiryTime = Carbon::parse($attempt->started_at)
            ->addMinutes($exam->duration);

        if (now()->greaterThan($expiryTime)) {
            return 'Time is up. You can no longer submit this exam.';
        }

        $score = 0;
        $answers = $request->input('answers', []);

        $attempt->answers()->delete();

        foreach ($answers as $questionId => $optionId) {
            $answer = Answer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $questionId,
                'option_id' => $optionId,
            ]);

            if ($answer->option->is_correct) {
                $score++;
            }
        }

        $attempt->update([
            'score' => $score,
        ]);

        if (! is_null($attempt->score)) {
            return redirect()->route('student.results', $attempt->id);
        }

        return redirect()->route('student.results', $attempt->id);
    }

    public function recordTabSwitch(Request $request, $examId): JsonResponse
    {
        $attempt = Attempt::where('user_id', Auth::id())
            ->where('exam_id', $examId)
            ->firstOrFail();

        $maxWarnings = 3;
        $attempt->increment('cheat_count');
        $attempt->refresh();

        return response()->json([
            'cheat_count' => $attempt->cheat_count,
            'remaining_warnings' => max($maxWarnings - $attempt->cheat_count, 0),
            'should_auto_submit' => $attempt->cheat_count >= $maxWarnings,
        ]);
    }

    public function result($attemptId)
    {
        $attempt = Attempt::with([
            'answers.option',
            'answers.question.options',
            'exam.questions.options',
        ])->findOrFail($attemptId);

        $score = $attempt->score;
        $total = $attempt->exam->questions->count();
        $percentage = $total > 0 ? ($score / $total) * 100 : 0;

        return view('student.result', compact('attempt', 'score', 'total', 'percentage'));
    }

    public function dashboard()
    {
        $user = auth()->user();

        $attempts = Attempt::with('exam')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $totalExams = $attempts->count();

        $averageScore = $attempts->avg('score');

        return view('student.dashboard', compact(
            'attempts',
            'totalExams',
            'averageScore'
        ));
    }

    public function leaderboard()
    {
        $leaders = Attempt::select(
            'user_id',
            DB::raw('AVG(score) as avg_score'),
            DB::raw('MAX(score) as best_score'),
            DB::raw('COUNT(*) as total_exams')
        )
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('avg_score')
            ->orderByDesc('best_score')
            ->get();

        return view('leaderboard', compact('leaders'));
    }
}

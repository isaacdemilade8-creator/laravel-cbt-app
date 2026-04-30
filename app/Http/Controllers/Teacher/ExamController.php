<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Auth::user()
            ->exams()
            ->withCount('questions')
            ->latest()
            ->get();

        return view('teacher.exams.index', compact('exams'));
    }

    public function create()
    {
        return view('teacher.exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'duration' => 'required|integer',
        ]);

        Auth::user()->exams()->create([
            'title' => $request->title,
            'duration' => $request->duration,
        ]);

        return redirect()->route('teacher.exams.index');
    }

    public function createQuestion($examId)
    {
        Exam::where('user_id', Auth::id())->findOrFail($examId);

        return view('teacher.questions.create', compact('examId'));
    }

    public function storeQuestion(Request $request, $examId)
    {
        Exam::where('user_id', Auth::id())->findOrFail($examId);

        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|size:4',
            'options.*' => 'required|string',
            'correct' => 'required|integer|min:0|max:3',
        ]);

        $question = Question::create([
            'exam_id' => $examId,
            'question_text' => $request->question_text,
        ]);

        foreach ($request->options as $index => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => $index == $request->correct
            ]);
        }

        return back();
    }
}

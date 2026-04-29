<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Auth::user()->exams ?? [];
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

        return redirect('/teacher/exams');
    }

    public function createQuestion($examId)
    {
        return view('teacher.questions.create', compact('examId'));
    }

    public function storeQuestion(Request $request, $examId)
    {
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

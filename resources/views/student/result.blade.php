<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/results.css'])
    <title>Document</title>
</head>

<body>
    <h1>Exam Result</h1>

<h3>Score: {{ $score }} / {{ $total }}</h3>
<h3>Percentage: {{ round($percentage, 2) }}%</h3>

<hr>

@foreach ($attempt->exam->questions as $question)
    <div>

        <p><strong>Q:</strong> {{ $question->question_text }}</p>

        @php
            $userAnswer = $attempt->answers->where('question_id', $question->id)->first();
        @endphp

        <p>
            <strong>Your Answer:</strong>
            @if ($userAnswer)
                {{ $userAnswer->option->option_text }}
            @else
                <em>Not answered</em>
            @endif
        </p>

        <p>
            <strong>Correct Answer:</strong>
            @foreach ($question->options as $option)
                @if ($option->is_correct)
                    {{ $option->option_text }}
                @endif
            @endforeach
        </p>

        @if ($userAnswer && $userAnswer->option->is_correct)
            <p style="color:green;">Correct</p>
        @else
            <p style="color:red;">Wrong</p>
        @endif

    </div>
@endforeach
</body>

</html>

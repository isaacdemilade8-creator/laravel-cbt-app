<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/student-dashboard.css'])
    <title>Document</title>
</head>
<body>
    <h2>Student Dashboard</h2>

<div style="display:flex; gap:20px; margin-bottom:20px;">

    <div style="padding:10px; border:1px solid #ccc;">
        <h3>Total Exams</h3>
        <p>{{ $totalExams }}</p>
    </div>

    <div style="padding:10px; border:1px solid #ccc;">
        <h3>Average Score</h3>
        <p>{{ number_format($averageScore, 2) }}</p>
    </div>

</div>

<hr>

<h3>My Attempts</h3>

@foreach ($attempts as $attempt)
    <div style="padding:10px; border:1px solid #ddd; margin-bottom:10px;">

        <p><strong>Exam:</strong> {{ $attempt->exam->title ?? 'Unknown' }}</p>

        <p><strong>Score:</strong> {{ $attempt->score ?? 'In progress' }}</p>

        <p><strong>Date:</strong> {{ $attempt->created_at->format('d M Y, h:i A') }}</p>

        @if (! is_null($attempt->score))
            <a href="{{ route('student.results', $attempt->id) }}">
                View Breakdown
            </a>
        @else
            <a href="{{ route('student.exams.show', $attempt->exam_id) }}">
                Continue Exam
            </a>
        @endif

    </div>
@endforeach
</body>
</html>

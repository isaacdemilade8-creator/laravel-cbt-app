<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teacher Exams</title>
    @vite(['resources/css/dashboard.css'])
</head>
<body>
    <h1>Teacher Exams</h1>

    <p>
        <a href="{{ route('teacher.exams.create') }}">Create Exam</a>
    </p>

    <div class="table-wrapper">
        <table>
            <tr>
                <th>Title</th>
                <th>Duration</th>
                <th>Questions</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>

            @forelse ($exams as $exam)
                <tr>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->duration }} min</td>
                    <td>{{ $exam->questions_count ?? $exam->questions->count() }}</td>
                    <td>{{ $exam->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <a href="{{ route('teacher.exams.questions.create', $exam->id) }}">Add Question</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No exams created yet.</td>
                </tr>
            @endforelse
        </table>
    </div>
</body>
</html>

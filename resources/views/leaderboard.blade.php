<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/leaderboard.css'])
    <title>Document</title>
</head>
<body>
    <h2>Leaderboard</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Rank</th>
        <th>Name</th>
        <th>Avg Score</th>
        <th>Best Score</th>
        <th>Exams Taken</th>
    </tr>

    @foreach ($leaders as $index => $leader)
        <tr>
            <td>#{{ $index + 1 }}</td>
            <td>{{ $leader->user->name ?? 'Unknown' }}</td>
            <td>{{ number_format($leader->avg_score, 2) }}</td>
            <td>{{ $leader->best_score }}</td>
            <td>{{ $leader->total_exams }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
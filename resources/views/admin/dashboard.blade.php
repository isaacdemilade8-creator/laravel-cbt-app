<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Dashboard</title>
    @vite(['resources/css/dashboard.css'])
</head>
<body>

<h1>Admin Dashboard</h1>

<div class="cards">
    <div class="card">
        <h2>{{ $totalUsers }}</h2>
        <p>Users</p>
    </div>
    <div class="card">
        <h2>{{ $totalExams }}</h2>
        <p>Exams</p>
    </div>
    <div class="card">
        <h2>{{ $totalAttempts }}</h2>
        <p>Attempts</p>
    </div>
    <div class="card">
        <h2>{{ round($averageScore, 2) }}</h2>
        <p>Avg Score</p>
    </div>
</div>

<h2>Analytics</h2>

<canvas id="attemptChart" height="100"></canvas>
<canvas id="scoreChart" height="100"></canvas>

<h2>Recent Attempts</h2>

<div class="table-wrapper">
<table>
    <tr>
        <th>User</th>
        <th>Exam</th>
        <th>Score</th>
        <th>Date</th>
        <th>Cheat Count</th>
    </tr>
    @foreach ($recentAttempts as $attempt)
        <tr>
            <td>{{ $attempt->user->name }}</td>
            <td>{{ $attempt->exam->title }}</td>
            <td>{{ $attempt->score }}</td>
            <td>{{ $attempt->created_at }}</td>
            <td>{{ $attempt->cheat_count }}</td>
        </tr>
    @endforeach
</table>
</div>

<h2>Flagged Students</h2>

<div class="table-wrapper">
<table>
    <tr>
        <th>Student</th>
        <th>Total Tab Switches</th>
        <th>Flagged Attempts</th>
    </tr>
    @forelse ($flaggedStudents as $student)
        <tr>
            <td>{{ $student->user->name }}</td>
            <td>{{ $student->total_cheat_count }}</td>
            <td>{{ $student->flagged_attempts }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3">No cheating records yet.</td>
        </tr>
    @endforelse
</table>
</div>

<h2>Hardest Questions</h2>

<div id="questionList">
    @foreach ($questionStats as $index => $stat)
        <div class="question-stat {{ $index >= 1 ? 'hidden-stat' : '' }}" data-index="{{ $index }}">
            <p class="stat-question">{{ $stat->question->question_text }}</p>
            <div class="stat-row">
                <span class="stat-item">Total <strong>{{ $stat->total_answers }}</strong></span>
                <span class="stat-item correct">Correct <strong>{{ $stat->correct_answers }}</strong></span>
                <span class="stat-item wrong">Wrong <strong>{{ $stat->total_answers - $stat->correct_answers }}</strong></span>
            </div>
        </div>
    @endforeach
</div>

<button id="seeMoreBtn" onclick="revealMore()">See More</button>

<script>
    const attemptLabels = {!! json_encode($attemptsPerExam->pluck('exam.title')) !!};
    const attemptData   = {!! json_encode($attemptsPerExam->pluck('total')) !!};
    const scoreLabels   = {!! json_encode($avgScorePerExam->pluck('exam.title')) !!};
    const scoreData     = {!! json_encode($avgScorePerExam->pluck('avg_score')) !!};
</script>

<script>
    Chart.defaults.color = '#7a8099';
    Chart.defaults.borderColor = '#ffffff10';

    new Chart(document.getElementById('attemptChart'), {
        type: 'bar',
        data: {
            labels: attemptLabels,
            datasets: [{
                label: 'Attempts per Exam',
                data: attemptData,
                backgroundColor: '#4f8ef730',
                borderColor: '#4f8ef7',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: { plugins: { legend: { labels: { color: '#7a8099' } } } }
    });

    new Chart(document.getElementById('scoreChart'), {
        type: 'bar',
        data: {
            labels: scoreLabels,
            datasets: [{
                label: 'Average Score',
                data: scoreData,
                backgroundColor: '#2dd4a025',
                borderColor: '#2dd4a0',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: { plugins: { legend: { labels: { color: '#7a8099' } } } }
    });
</script>

<script>
    let stage = 0;
    const stats = document.querySelectorAll('.question-stat');
    const btn   = document.getElementById('seeMoreBtn');

    function revealMore() {
        if (stage === 0) {
            stats.forEach((el, i) => { if (i < 6) el.classList.remove('hidden-stat'); });
            stage = 1;
            btn.textContent = stats.length <= 6 ? 'Hide' : 'See More';
        } else if (stage === 1) {
            stats.forEach(el => el.classList.remove('hidden-stat'));
            stage = 2;
            btn.textContent = 'Hide';
        } else if (stage === 2) {
            stats.forEach((el, i) => { if (i >= 1) el.classList.add('hidden-stat'); });
            stage = 0;
            btn.textContent = 'See More';
        }
    }

    if (stats.length <= 1) btn.style.display = 'none';
</script>

</body>
</html>

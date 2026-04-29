<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/style.css'])
</head>

<body>
    <div id="warningBox" style="display:none; background:red; color:white; padding:10px; text-align:center;">
        Warning: You switched tabs! Stay on the exam page.
    </div>
    <div class="top-bar">
        <div class="top-bar-row">
            <div>Time Left: <span id="timer"></span></div>

            <div class="progress-wrapper">
                <div class="progress-label">
                    <span>Progress</span>
                    <span id="progressText">0/0</span>
                </div>
                <div class="progress-track">
                    <div id="progressBar"></div>
                </div>
            </div>
        </div>

        <div id="palette">
            <div id="palette">
                @foreach ($exam->questions as $index => $question)
                    <button type="button" class="palette-btn" onclick="goToQuestion({{ $index }})">
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container">
        <form id="examForm" action="/student/exams/{{ $exam->id }}/submit" method="post">
            @csrf

            @foreach ($exam->questions as $index => $question)
                <div class="question">
                    <h3>Question {{ $index + 1 }}</h3>
                    <p>{{ $question->question_text }}</p>

                    @foreach ($question->options as $option)
                        <label>
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}">
                            {{ $option->option_text }}
                        </label>
                    @endforeach
                </div>
            @endforeach

            <div class="nav-buttons">
                <button type="button" onclick="prevQuestion()">Previous</button>
                <button type="button" onclick="nextQuestion()">Next</button>
                <button type="button" onclick="handleSubmit()">Submit</button>
            </div>
        </form>
    </div>

    <script>
        const duration = {{ $exam->duration }} * 60;
        const startTime = new Date("{{ \Carbon\Carbon::parse($attempt->started_at)->toIso8601String() }}").getTime();
        const tabSwitchEndpoint = "{{ route('student.exams.tab-switch', $exam->id) }}";
        const csrfToken = "{{ csrf_token() }}";
        let submitted = false;

        function submitExam() {
            if (submitted) return;

            submitted = true;
            document.getElementById("examForm").submit();
        }

        function startTimer() {
            const timerEl = document.getElementById("timer");

            const interval = setInterval(() => {
                const now = new Date().getTime();
                const elapsed = Math.floor((now - startTime) / 1000);
                let remaining = duration - elapsed;

                if (remaining <= 0) {
                    timerEl.innerHTML = "0:00";
                    clearInterval(interval);
                    submitExam();
                    return;
                }

                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;

                timerEl.innerHTML = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }, 1000);
        }

        startTimer();
    </script>
    <script>
        let currentQuestion = 0;
        const questions = document.querySelectorAll('.question');

        function updateProgress() {
            let answered = 0;
            const total = questions.length;

            questions.forEach((questionDiv) => {
                const checked = questionDiv.querySelector('input[type="radio"]:checked');
                if (checked) answered++;
            });

            const percent = Math.round((answered / total) * 100);

            document.getElementById("progressText").innerText = `${answered}/${total}`;
            document.getElementById("progressBar").style.width = `${percent}%`;
        }

        function showQuestion(index) {
            questions.forEach((q, i) => {
                q.style.display = i === index ? 'block' : 'none';
            });
        }

        function updatePalette() {
            const buttons = document.querySelectorAll('.palette-btn');

            buttons.forEach((btn, index) => {
                const questionDiv = questions[index];
                const checked = questionDiv.querySelector('input[type="radio"]:checked');

                btn.style.backgroundColor = '';
                btn.style.color = '';

                if (index === currentQuestion) {
                    btn.style.backgroundColor = 'blue';
                    btn.style.color = 'white';
                } else if (checked) {
                    btn.style.backgroundColor = 'green';
                    btn.style.color = 'white';
                } else {
                    btn.style.backgroundColor = 'red';
                    btn.style.color = 'white';
                }
            });
        }

        document.querySelectorAll('input[type="radio"]').forEach(input => {
            input.addEventListener('change', () => {
                updatePalette();
                updateProgress();
            });
        });

        function nextQuestion() {
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                showQuestion(currentQuestion);
                updatePalette();
                updateNavigationButtons();
            }
        }

        function prevQuestion() {
            if (currentQuestion > 0) {
                currentQuestion--;
                showQuestion(currentQuestion);
                updatePalette();
                updateNavigationButtons();
            }
        }

        function goToQuestion(index) {
            currentQuestion = index;
            showQuestion(currentQuestion);
            updatePalette();
            updateNavigationButtons();
        }

        function updateNavigationButtons() {
            document.querySelector('button[onclick="prevQuestion()"]').disabled = currentQuestion === 0;
            document.querySelector('button[onclick="nextQuestion()"]').disabled = currentQuestion === questions.length - 1;
        }

        showQuestion(currentQuestion);
        updatePalette();
        updateNavigationButtons();
        updateProgress();
    </script>
    <script>
        function handleSubmit() {
            if (submitted) return;

            let unanswered = 0;

            questions.forEach((questionDiv) => {
                const checked = questionDiv.querySelector('input[type="radio"]:checked');
                if (!checked) unanswered++;
            });

            if (unanswered > 0) {
                const confirmSubmit = confirm(
                    `You have ${unanswered} unanswered question(s). Submit anyway?`
                );

                if (!confirmSubmit) return;
            }

            submitExam();
        }
    </script>
    <script>
        async function recordTabSwitch() {
            const response = await fetch(tabSwitchEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ switched_at: new Date().toISOString() }),
                keepalive: true,
            });

            if (!response.ok) {
                throw new Error('Unable to record tab switch.');
            }

            return response.json();
        }

        function showWarning(message, persist = false) {
            const box = document.getElementById('warningBox');
            box.style.display = 'block';
            box.innerHTML = message;

            if (!persist) {
                setTimeout(() => {
                    box.style.display = 'none';
                }, 5000);
            }
        }

        document.addEventListener('visibilitychange', async function() {
            if (!document.hidden || submitted) {
                return;
            }

            try {
                const result = await recordTabSwitch();

                if (result.should_auto_submit) {
                    showWarning('&#9888; You have been auto-submitted for leaving the exam page too many times.', true);
                    submitExam();
                    return;
                }

                showWarning(`&#9888; Warning: You left the exam page (${result.cheat_count}/3). ${result.remaining_warnings} warning(s) left before auto-submit.`);
            } catch (error) {
                showWarning('&#9888; Your tab switch could not be recorded. Please stay on the exam page.');
            }
        });
    </script>
</body>

</html>

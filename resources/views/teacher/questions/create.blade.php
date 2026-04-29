<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Question</title>
    @vite(['/resources/css/add-question.css'])
</head>
<body>
    <h2>Add Question</h2>

    <form method="POST" action="/teacher/exams/{{ $examId }}/questions">
        @csrf

        <span class="field-label">Question</span>
        <input type="text" name="question_text" placeholder="Enter question">

        <div class="options-section">
            <span class="field-label">Options</span>

            <div class="option-row">
                <span class="option-number">1</span>
                <input type="text" name="options[]" placeholder="Option 1">
            </div>
            <div class="option-row">
                <span class="option-number">2</span>
                <input type="text" name="options[]" placeholder="Option 2">
            </div>
            <div class="option-row">
                <span class="option-number">3</span>
                <input type="text" name="options[]" placeholder="Option 3">
            </div>
            <div class="option-row">
                <span class="option-number">4</span>
                <input type="text" name="options[]" placeholder="Option 4">
            </div>
        </div>

        <div class="correct-section">
            <span class="field-label">Correct Option</span>

            <label><input type="radio" name="correct" value="0"> Option 1</label>
            <label><input type="radio" name="correct" value="1"> Option 2</label>
            <label><input type="radio" name="correct" value="2"> Option 3</label>
            <label><input type="radio" name="correct" value="3"> Option 4</label>
        </div>

        <button type="submit">Save Question</button>
    </form>
</body>
</html>
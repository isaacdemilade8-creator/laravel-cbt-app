<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Create exam</h2>

    <form method="POST" action="/teacher/exams">
        @csrf

        <input type="text" name="title" placeholder="Exam Title"><br><br>

        <input type="number" name="duration" placeholder="Duration in minutes"><br><br>

        <button type="submit">Create Exam</button>
    </form>
</body>
</html>

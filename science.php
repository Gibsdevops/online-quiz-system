<?php
require 'auth.php';
require 'db.php';

$quiz_id = $_GET['id'] ?? null;
if (!$quiz_id) {
    echo "Quiz not found!";
    exit;
}

// Sample questions array (simulating database results)
$questions = [
    [
        'id' => 1,
        'text' => 'What is the boiling point of water at sea level?',
        'choices' => ['100°C', '0°C', '50°C', '212°F']
    ],
    [
        'id' => 2,
        'text' => 'Which planet is known as the Red Planet?',
        'choices' => ['Earth', 'Mars', 'Jupiter', 'Venus']
    ],
    [
        'id' => 3,
        'text' => 'What is the chemical symbol for water?',
        'choices' => ['H2O', 'O2', 'CO2', 'NaCl']
    ],
    [
        'id' => 4,
        'text' => 'What gas do plants absorb from the atmosphere?',
        'choices' => ['Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Helium']
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Science Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // JavaScript for countdown timer
        let timeLeft = 300; // 5 minutes (300 seconds)
        
        function startTimer() {
            const timerDisplay = document.getElementById('timer');
            const timerInterval = setInterval(() => {
                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                timeLeft--;

                if (timeLeft < 0) {
                    clearInterval(timerInterval);
                    document.getElementById('quiz-form').submit(); // Auto-submit when time is up
                }
            }, 1000);
        }

        window.onload = startTimer; // Start timer when page loads
    </script>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Science Quiz</h1>
        <div id="timer" class="btn btn-outline-danger">5:00</div> <!-- Timer display -->
    </div>

    <form id="quiz-form" action="submit_quiz.php" method="post">
        <input type="hidden" name="quiz_id" value="<?= htmlspecialchars($quiz_id); ?>">
        
        <?php foreach ($questions as $index => $question): ?>
            <div class="mb-4">
                <h5><?= ($index + 1) . '. ' . htmlspecialchars($question['text']); ?></h5>
                <?php foreach ($question['choices'] as $choice): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[<?= $question['id']; ?>]" value="<?= htmlspecialchars($choice); ?>">
                        <label class="form-check-label"><?= htmlspecialchars($choice); ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">Submit Quiz</button>
    </form>
</div>
</body>
</html>



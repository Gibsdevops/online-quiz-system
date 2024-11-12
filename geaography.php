<?php
require 'auth.php'; // Ensure the user is authenticated
require 'db.php';   // Database connection

$quiz_id = $_GET['id'] ?? null;  // Retrieve the quiz ID from the URL
if (!$quiz_id) {
    echo "Quiz not found!";
    exit;
}

// Fetch questions specific to this quiz from the database
$stmt = $pdo->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$stmt->execute([$quiz_id]);
$questions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Geography Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Geography Quiz</h1>
    <form action="submit_quiz.php" method="post">
        <!-- Hidden input to store quiz ID for submission -->
        <input type="hidden" name="quiz_id" value="<?= htmlspecialchars($quiz_id); ?>">
        
        <!-- Loop through each question -->
        <?php foreach ($questions as $index => $question): ?>
            <div class="mb-3">
                <label><?= ($index + 1) . '. ' . htmlspecialchars($question['text']); ?></label>
                
                <!-- Display each choice as a radio button option -->
                <?php foreach (json_decode($question['choices']) as $choice): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[<?= $question['id']; ?>]" value="<?= htmlspecialchars($choice); ?>">
                        <label class="form-check-label"><?= htmlspecialchars($choice); ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        
        <!-- Submit button to submit the quiz -->
        <button type="submit" class="btn btn-primary">Submit Quiz</button>
    </form>
</div>
</body>
</html>

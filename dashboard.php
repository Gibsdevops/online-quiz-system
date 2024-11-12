<?php
require 'auth.php'; // Ensures the user is logged in
require 'db.php';   // Includes the database connection

// Fetch the username based on the user ID stored in the session
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found!";
    exit;
}

// Fetch recent quiz attempts for this user
$stmt = $pdo->prepare("SELECT quizzes.title, attempts.score, attempts.created_at 
                       FROM attempts 
                       JOIN quizzes ON attempts.quiz_id = quizzes.id 
                       WHERE attempts.user_id = ? 
                       ORDER BY attempts.created_at DESC 
                       LIMIT 5");
$stmt->execute([$_SESSION['user_id']]);
$recent_attempts = $stmt->fetchAll();

// Fetch all available quizzes
$quizzes = $pdo->query("SELECT * FROM quizzes")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Welcome, <?= htmlspecialchars($user['username']); ?>!</h1>
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
    
    <div class="row">
        <!-- Recent Attempts Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4>Recent Quiz Attempts</h4>
                </div>
                <ul class="list-group list-group-flush">
                    <?php if (count($recent_attempts) > 0): ?>
                        <?php foreach ($recent_attempts as $attempt): ?>
                            <li class="list-group-item">
                                <strong><?= htmlspecialchars($attempt['title']); ?></strong><br>
                                Score: <?= htmlspecialchars($attempt['score']); ?> <br>
                                Date: <?= htmlspecialchars(date("F j, Y, g:i a", strtotime($attempt['created_at']))); ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item">No quiz attempts yet.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        
        <!-- Available Quizzes Section -->
                        <!-- Available Quizzes Section -->
<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-header">
            <h4>Available Quizzes</h4>
        </div>
        <ul class="list-group list-group-flush">
            <?php if (count($quizzes) > 0): ?>
                <?php foreach ($quizzes as $quiz): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($quiz['title']); ?>
                        <a href="<?= strtolower($quiz['title']); ?>.php?id=<?= $quiz['id']; ?>" class="btn btn-primary btn-sm">Take Quiz</a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">No quizzes available.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>


    </div>
</div>
</body>
</html>





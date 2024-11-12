<?php
require 'auth.php'; // Ensure user is logged in
require 'db.php';   // Database connection

// Handle form submission to add a quiz
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    
    if (empty($title)) {
        $error = "Title is required!";
    } else {
        // Insert quiz into the database
        $stmt = $pdo->prepare("INSERT INTO quizzes (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);
        
        // Redirect to the quiz list or show a success message
        header('Location: quiz_list.php'); // Assuming you have a page that lists quizzes
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Add New Quiz</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Quiz Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Add Quiz</button>
    </form>
</div>
</body>
</html>

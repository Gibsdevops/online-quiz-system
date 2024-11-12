<?php
session_start(); // Start the session if it hasn't been started already

// Check if the user is logged in by verifying if `user_id` is set in the session
if (!isset($_SESSION['user_id'])) {
    // If `user_id` is not set, redirect the user to the login page
    header('Location: login.php');
    exit; // Stop further execution of the script after redirection
}
?>

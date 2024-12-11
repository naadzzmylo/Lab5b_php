<?php
session_start(); // Start session to access session variables
if (!isset($_SESSION['user'])) { // Check if the user is not logged in
    header('Location: login.php'); // Redirect to login page if not logged in
    exit; // Stop further execution
}
?>

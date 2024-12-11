<?php
session_start(); // Start session to handle login data

if (isset($_SESSION['user'])) { // Redirect if already logged in
    header('Location: display.php');
    exit;
}
$conn = new mysqli('localhost', 'root', '', 'Lab_5b'); // Connect to the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if login form is submitted
    $matric = $_POST['matric']; // Get matric from form
    $password = $_POST['password']; // Get password from form
    // Fetch user details based on matric
    $sql = "SELECT * FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) { // Check if user exists
        $user = $result->fetch_assoc(); // Fetch user data
        if (password_verify($password, $user['password'])) { // Verify hashed password
            // Store user information in session
            $_SESSION['user'] = [
                'matric' => $user['matric'],
                'name' => $user['name'],
                'role' => $user['role']
            ];
            header('Location: display.php'); // Redirect to display page
            exit;
        } else {
            $error = "Invalid username or password, try login again."; // Error for invalid password
        }
    } else {
        $error = "Invalid username or password, try login again."; // Error for user not found
    }
}
?>
<!-- HTML form for user login -->
<h2>Login</h2>
<form method="POST" action="">
    <label>Matric:</label>
    <input type="text" name="matric" required><br> <!-- Input for matric -->
    <label>Password:</label>
    <input type="password" name="password" required><br> <!-- Input for password -->
    <button type="submit">Login</button> <!-- Submit button -->
</form>
<!-- Display error message if login fails -->
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<!-- Guide for users to register if they don't have an account -->
<p><a href="register.php">Register</a> here if you have not</p> <!-- Link to registration page -->

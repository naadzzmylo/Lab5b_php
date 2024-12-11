<?php
include 'auth.php'; // Ensure user is logged in
$conn = new mysqli('localhost', 'root', '', 'Lab_5b'); // Connect to the database
if ($conn->connect_error) { // Check database connection
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if update form is submitted
    $original_matric = $_POST['original_matric']; // Get original matric
    $matric = $_POST['matric']; // Get new matric
    $name = $_POST['name']; // Get updated name
    $role = $_POST['role']; // Get updated role
    $sql = "UPDATE users SET matric = '$matric', name = '$name', role = '$role' WHERE matric = '$original_matric'";
    if ($conn->query($sql) === TRUE) { // Check if update is successful
        header('Location: display.php'); // Redirect to display page
        exit;
    } else {
        echo "Error updating record: " . $conn->error; // Show error if update fails
    }
}
// Fetch user data based on matric
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $result = $conn->query("SELECT * FROM users WHERE matric = '$matric'");
    $user = $result->fetch_assoc(); // Fetch user details
    if (!$user) { // Check if user exists
        echo "User not found!";
        exit;
    }
} else {
    echo "No user selected!";
    exit;
}
?>
<h2>Update User</h2>
<form method="POST" action="">
    <input type="hidden" name="original_matric" value="<?php echo htmlspecialchars($user['matric']); ?>"> <!-- Hidden input for original matric -->
    <label>Matric:</label>
    <input type="text" name="matric" value="<?php echo htmlspecialchars($user['matric']); ?>" required><br> <!-- Input for matric -->
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br> <!-- Input for name -->
    <label>Role:</label>
    <select name="role"> <!-- Dropdown for role -->
        <option value="student" <?php echo $user['role'] == 'student' ? 'selected' : ''; ?>>Student</option>
        <option value="lecturer" <?php echo $user['role'] == 'lecturer' ? 'selected' : ''; ?>>Lecturer</option>
    </select><br>
    <button type="submit">Update</button> <!-- Submit button -->
    <a href="display.php">Cancel</a> <!-- Cancel button -->
</form>

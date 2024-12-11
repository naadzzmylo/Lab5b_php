<?php
$conn = new mysqli('localhost', 'root', '', 'Lab_5b'); // Connect to the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if form is submitted
    $matric = $_POST['matric']; // Get matric from form
    $name = $_POST['name']; // Get name from form
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password for security
    $role = $_POST['role']; // Get role from form

    // Insert the user data into the database
    $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$password', '$role')";
    if ($conn->query($sql) === TRUE) { // Check if insertion is successful
        $success = true; // Flag for successful registration
    } else {
        echo "Error: " . $conn->error; // Display error if insertion fails
    }
}
?>
<!-- HTML form for user registration -->
<form method="POST" action="">
    <label>Matric:</label>
    <input type="text" name="matric" required><br> <!-- Input for matric -->
    <label>Name:</label>
    <input type="text" name="name" required><br> <!-- Input for name -->
    <label>Password:</label>
    <input type="password" name="password" required><br> <!-- Input for password -->
    <label>Role:</label>
    <select name="role"> <!-- Dropdown for role selection -->
        <option value="student">Student</option>
        <option value="lecturer">Lecturer</option>
    </select><br>
    <button type="submit">Submit</button> <!-- Submit button -->
</form>
<!-- Display success message and user-entered data -->
<?php if (isset($success) && $success): ?>
    <h3 style="color: green;">User registered successfully!</h3>
    <h3>Data Entered:</h3>
    <table border="1">
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Role</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($matric); ?></td> <!-- Display matric -->
            <td><?php echo htmlspecialchars($name); ?></td> <!-- Display name -->
            <td><?php echo htmlspecialchars($role); ?></td> <!-- Display role -->
        </tr>
    </table>
<?php endif; ?>

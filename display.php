<?php
include 'auth.php'; // Ensure user is logged in

$conn = new mysqli('localhost', 'root', '', 'Lab_5b'); // Connect to the database

if (isset($_GET['delete'])) { // Check if delete action is triggered
    $matric = $_GET['delete']; // Get matric of user to delete
    $conn->query("DELETE FROM users WHERE matric = '$matric'"); // Delete user from database
    header('Location: display.php'); // Redirect to refresh the page
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_start();
    session_destroy(); // Destroy session
    header('Location: login.php'); // Redirect to login page
    exit;
}

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Display users in a table
echo "<h2>User List</h2>";
echo "<table border='1'>";
echo "<tr><th>Matric</th><th>Name</th><th>Role</th><th>Action</th></tr>";
while ($row = $result->fetch_assoc()) { // Loop through all users
    echo "<tr>
        <td>{$row['matric']}</td> <!-- Display matric -->
        <td>{$row['name']}</td> <!-- Display name -->
        <td>{$row['role']}</td> <!-- Display role -->
        <td>
            <a href='update.php?matric={$row['matric']}'>Update</a> <!-- Link to update -->
            <a href='display.php?delete={$row['matric']}'>Delete</a> <!-- Link to delete -->
        </td>
    </tr>";
}
echo "</table>";

// Add a logout button
echo "<br><a href='display.php?logout=true'>Logout</a>"; // Logout link
?>

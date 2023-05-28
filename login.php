
<?php
// Database connection details
$servername = "localhost:3307";
$username = "web";
$password = "web_admin";
$dbname = "company";

// Establish the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the login form is submitted
if (isset($_POST['submit'])) {
    // Get the entered username and password from the form
    $username = intval($_POST['username']);
    $password = intval($_POST['password']);

    // Prepare the SQL statement
    $sql = "SELECT * FROM usrs WHERE id = $username AND password = $password";

    // Execute the query
    $result = $conn->query($sql);

    // Check if a matching user is found
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $id = $row['ID'];

        // Redirect based on the user's ID
        if ($id >= 10000 && $id < 20000) {
            header("Location: routes/doctor_page.php");
            exit();
        } elseif ($id >= 20000 && $id < 30000) {
            header("Location: routes/nurse_page.php");
            exit();
        } else {
            echo "Invalid user type!";
        }
    } else {
        echo "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="number" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="number" name="password" id="password" required><br>

        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>

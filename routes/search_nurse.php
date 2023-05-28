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

// Initialize variables
$searchCondition = '';
$searchValue = '';

// Check if the search form is submitted
if (isset($_POST['submit'])) {
    $searchCondition = $_POST['condition'];
    $searchValue = $_POST['search'];

    // Prepare the SQL statement based on the selected condition
    $sql = "SELECT * FROM CHART c JOIN MEDICER d ON c.CDIG = d.DIGID ";

    if ($searchCondition === 'doct_id') {
        $sql .= "WHERE c.CDOC = '$searchValue'";
    } elseif ($searchCondition === 'date') {
        $sql .= "WHERE d.VDATE = '$searchValue'";
    } elseif ($searchCondition === 'chart_no') {
        $sql .= "WHERE c.CNO = '$searchValue'";
    }

    // Execute the query
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function showAlert() {
            alert("No matching result found!");
        }
    </script>
</head>
<body>
    <h1>Search</h1>
    <form method="post" action="">
        <label for="condition">Search Condition:</label>
        <select name="condition" id="condition">
            <option value="doct_id" <?php if ($searchCondition === 'doct_id') echo 'selected'; ?>>doct_ID</option>
            <option value="date" <?php if ($searchCondition === 'date') echo 'selected'; ?>>date</option>
            <option value="chart_no" <?php if ($searchCondition === 'chart_no') echo 'selected'; ?>>chart_no</option>
        </select>
        <br>
        <label for="search">Search Value:</label>
        <input type="text" name="search" id="search" value="<?php echo $searchValue; ?>" required>
        <input type="submit" name="submit" value="Search">
    </form>

    <?php
    // Display search results if available
    
    // Button to go to 'doctor_page.php'
    echo "<br>";
    echo "<form action='nurse_page.php'>";
    echo "<input type='submit' value='Go to Nurse Page'>";
    echo "</form>";
    if (isset($result)) {
        if ($result->num_rows > 0) {
            echo "<h2>Search Results:</h2>";
            echo "<table>";
            echo "<tr><th>Chart No</th><th>Patient ID</th><th>Nurse ID</th><th>Doctor ID</th><th>Date</th><th>Pres</th><th>Symptom</th></tr>";
            $row = $result->fetch_assoc();
            echo "<tr>";
            echo "<td>" . $row['CNO'] . "</td>";
            echo "<td>" . $row['CPAT'] . "</td>";
            echo "<td>" . $row['CNUR'] . "</td>";
            echo "<td>" . $row['CDOC'] . "</td>";
            echo "<td>" . $row['VDATE'] . "</td>";
            echo "<td>" . $row['PRES'] . "</td>";
            echo "<td>" . $row['SYMPTOM'] . "</td>";
            echo "</tr>";
            echo "</table>";

            // Button to go to 'doctor_page.php'
//            echo "<br>";
//            echo "<form action='doctor_page.php'>";
//            echo "<input type='submit' value='Go to Doctor Page'>";
//            echo "</form>";
        } else {
            // No matching result found
            echo "<script>showAlert();</script>";
        }
    }
    ?>

</body>
</html>

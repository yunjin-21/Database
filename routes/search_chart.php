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
    $sql = "SELECT c.CNO, c.DISEASE, mc.SYMPTOM, mc.VDATE, d.NAME AS CDOC, n.NAME AS CNUR, p.NAME AS CPAT, c.PRES
            FROM CHART c
            LEFT JOIN MediCer mc ON c.CDIG = mc.DIGID
            LEFT JOIN DOCTOR d ON c.CDOC = d.DID
            LEFT JOIN NURSE n ON c.CNUR = n.NID
            LEFT JOIN PATIENT p ON c.CPAT = p.PID";

    if ($searchCondition === 'cno') {
        $sql .= " WHERE c.CNO = '$searchValue'";
    } elseif ($searchCondition === 'disease') {
        $sql .= " WHERE c.DISEASE LIKE '%$searchValue%'";
    } elseif ($searchCondition === 'patient') {
        $sql .= " WHERE p.NAME LIKE '%$searchValue%'";
    }

    // Execute the query
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Chart</title>
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
</head>
<body>
    <h1>Search Chart</h1>
    <form method="post" action="">
        <label for="condition">Search Condition:</label>
        <select name="condition" id="condition">
            <option value="cno" <?php if ($searchCondition === 'cno') echo 'selected'; ?>>Chart Number</option>
            <option value="disease" <?php if ($searchCondition === 'disease') echo 'selected'; ?>>Disease</option>
            <option value="patient" <?php if ($searchCondition === 'patient') echo 'selected'; ?>>Patient Name</option>
        </select>
        <br>
        <label for="search">Search Value:</label>
        <input type="text" name="search" id="search" value="<?php echo $searchValue; ?>" required>
        <input type="submit" name="submit" value="Search">
    </form>

    <?php
    // Display search results if available
    if (isset($result) && $result->num_rows > 0) {
        echo "<h2>Search Results:</h2>";
        echo "<table>";
        echo "<tr><th>Chart Number</th><th>Disease</th><th>Symptom</th><th>Visit Date</th><th>Doctor</th><th>Nurse</th><th>Patient</th><th>Prescription</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['CNO'] . "</td>";
            echo "<td>" . $row['DISEASE'] . "</td>";
            echo "<td>" . $row['SYMPTOM'] . "</td>";
            echo "<td>" . $row['VDATE'] . "</td>";
            echo "<td>" . $row['CDOC'] . "</td>";
            echo "<td>" . $row['CNUR'] . "</td>";
            echo "<td>" . $row['CPAT'] . "</td>";
            echo "<td>" . $row['PRES'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>

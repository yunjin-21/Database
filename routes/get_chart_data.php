<?php
// Assuming you have already established a database connection
// MariaDB database connection settings
$host = 'localhost:3307';
$user = 'web';
$password = 'web_admin';
$database = 'company';

// Connect to MariaDB
$connection = new \mysqli($host, $user, $password, $database);
// Function to generate the day chart using JPGraph
function generateDayChart($conn) {
    // Include the JPGraph library files
    require_once('C:\xampp\php\jpgraph-4.4.1\jpgraph-4.4.1\src\jpgraph.php');
		require_once('C:\xampp\php\jpgraph-4.4.1\jpgraph-4.4.1\src\jpgraph_bar.php');

    // Query to retrieve the count of patients visited by month
    $query = "SELECT DATE_FORMAT(vdate, '%Y-%m') AS visit_month, COUNT(*) AS visit_count
              FROM patient
              GROUP BY visit_month
              ORDER BY visit_month";

    $result = $conn->query($query);

    // Arrays to store the chart data
    $visitMonths = array();
    $visitCounts = array();

    // Fetching the data and populating the chart data arrays
    while ($row = mysqli_fetch_assoc($result)) {
        $visitMonths[] = $row['visit_month'];
        $visitCounts[] = (int) $row['visit_count'];
    }

    // Closing the database connection
    mysqli_close($connection);

    // Create a new graph
    $graph = new Graph(800, 400);
    $graph->SetScale('textlin');

    // Set graph title
    $graph->title->Set('Number of Patients Visited by Month');

    // Set X-axis labels
    $graph->xaxis->SetTickLabels($visitMonths);

    // Create a bar plot
    $barPlot = new BarPlot($visitCounts);

    // Add the bar plot to the graph
    $graph->Add($barPlot);

    // Display the graph
    $graph->Stroke();
}

// Call the generateDayChart function
generateDayChart();
?>

<?php
require_once('C:\xampp\php\jpgraph-4.4.1\jpgraph-4.4.1\src\jpgraph.php');
require_once('C:\xampp\php\jpgraph-4.4.1\jpgraph-4.4.1\src\jpgraph_bar.php');

// MariaDB database connection settings
$host = 'localhost:3307';
$user = 'web';
$password = 'web_admin';
$database = 'company';

// Connect to MariaDB
$conn = new \mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle button click
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Generate chart
    if ($action === 'chart') {
        generateChart($conn);
    }
    // Generate table
    elseif ($action === 'table') {
        generateTable($conn);
    }
    else if ($action == 'day') {
    	generateDayChart($conn);
    }
}

function generateDayChart($conn) {
    

    // Query to retrieve the count of patients visited by month
    $query = "SELECT DATE_FORMAT(vdate, '%Y-%m-%d') AS visit_month, COUNT(*) AS visit_count
              FROM MediCer
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
    mysqli_close($conn);

    // Create a new graph
    $graph = new Graph(800, 400);
    $graph->SetScale('textlin');

    // Set graph title
    $graph->title->Set('Number of Patients Visited by Day');

    // Set X-axis labels
    $graph->xaxis->SetTickLabels($visitMonths);

    // Create a bar plot
    $barPlot = new BarPlot($visitCounts);

    // Add the bar plot to the graph
    $graph->Add($barPlot);

    // Display the graph
    $graph->Stroke();
}

// Function to generate the chart
function generateChart($conn) {
    // Execute SQL query to get the count of patients by age and sex
    $query = "
        SELECT sex, SUBSTRING(resid,8,1) AS gubun, SUBSTRING(resid,1, 2) AS year, COUNT(*) AS count
        FROM patient
        GROUP BY sex, year
        ORDER BY sex, year
    ";
    $result = $conn->query($query);

    // Prepare data for plotting
		$maleData = array("20s" => 0, "30s" => 0, "40s" => 0, "50s" => 0, "60s" => 0);
		$femaleData = array("20s" => 0, "30s" => 0, "40s" => 0, "50s" => 0, "60s" => 0);
		$ageLabels = array("20s", "30s", "40s", "50s", "60s");
		$maxCount = 0;

		while ($row = $result->fetch_assoc()) {
    		$sex = $row['sex'];
    		$gubun = $row['gubun'];
    		$year = $row['year'];
    		$count = $row['count'];
    		
    		if($gubun==1 || $gubun==2)    //1900���(����:1, ����:2)
        	$year_prefix = "19";
    		else if($gubun==3 || $gubun==4)    //2000���(����:3, ����:4)
        	$year_prefix = "20";
    		else if($gubun==9 || $gubun==0)    //1800���(����:9, ����:0)
        	$year_prefix = "18";
    		else
        	return 0;

    		// Determine the age group based on the year
    		$age = (date('Y') - intval($year_prefix.$year)) + 1;

    		// Assign the age group label based on the calculated age
    		if ($age >= 20 && $age < 30) {
        		$ageLabel = "20s";
    		} elseif ($age >= 30 && $age < 40) {
        		$ageLabel = "30s";
    		} elseif ($age >= 40 && $age < 50) {
        		$ageLabel = "40s";
    		} elseif ($age >= 50 && $age < 60) {
        		$ageLabel = "50s";
    		} elseif ($age >= 60) {
        		$ageLabel = "60s";
    		}

    		if ($sex == 'M') {
        	$maleData[$ageLabel] += $count;
    		} else {
        	$femaleData[$ageLabel] += $count;
    		}
    		
    		if ($count > $maxCount){
    			$maxCount = $count;
    		}
    		
    		if(!in_array($ageLabel, $ageLabels)){
    			$ageLabels[] = $ageLabel;
    		}
		}
		
		sort($ageLabels);

		// Set the order of age groups for x-axis labels
//		$ageLabels = array('20s', '30s', '40s', '50s', '60s');

    // Create the graph
    $graph = new Graph(600, 400);
    $graph->SetScale('textlin');

    // Set up the titles
    $graph->title->Set('Number of Patients by Age Group and Gender');
    $graph->xaxis->title->Set('Age Group');
    $graph->yaxis->title->Set('Number of Patients');

    // Set up the colors for male and female
    $maleColor = '#3366cc';
    $femaleColor = '#ff6699';

    // Create a new bar plot for male data
		$malePlot = new BarPlot(array_values($maleData));
		$malePlot->SetFillColor('blue');
		$malePlot->SetLegend('Male');

		// Create a new bar plot for female data
		$femalePlot = new BarPlot(array_values($femaleData));
		$femalePlot->SetFillColor('red');
		$femalePlot->SetLegend('Female');

    // Create a grouped bar plot
		$gbplot = new GroupBarPlot(array($malePlot, $femalePlot));

		// Add the bar plots to the graph
		$graph->Add($gbplot);

		// Set labels for the x-axis
		$xAxisLabels = $ageLabels;
		$graph->xaxis->SetTickLabels($xAxisLabels);

		// Calculate the maximum value for the y-axis with a margin
		$margin = 10; // Adjust the margin as needed
		$yMax = ceil(($maxCount + $margin) / 10) * 10; // Round up to the nearest multiple of 10
		$graph->yaxis->scale->SetAutoMax($yMax);

		// Display the graph
		$graph->Stroke();
		}
		
		// Function to generate the table
function generateTable($conn) {
    // Execute SQL query to get the count of patients by age and sex
    $query = "
        SELECT sex, SUBSTRING(resid,8,1) AS gubun, SUBSTRING(resid,1, 2) AS year, COUNT(*) AS count
        FROM patient
        GROUP BY sex, year
        ORDER BY sex, year
    ";
    $result = $conn->query($query);

    // Prepare data for the table
    $tableData = array();
    $ageGroups = array('20s', '30s', '40s', '50s', '60s');

    // Initialize table data array
    foreach ($ageGroups as $ageGroup) {
        $tableData[$ageGroup] = array('F' => 0, 'M' => 0);
    }

    // Process query results and populate table data
    while ($row = $result->fetch_assoc()) {
        $sex = $row['sex'];
        $gubun = $row['gubun'];
        $year = $row['year'];
        $count = $row['count'];

        if ($gubun == 1 || $gubun == 2) {
            $year_prefix = "19";
        } elseif ($gubun == 3 || $gubun == 4) {
            $year_prefix = "20";
        } elseif ($gubun == 9 || $gubun == 0) {
            $year_prefix = "18";
        } else {
            return 0;
        }

        // Determine the age group based on the year
        $age = (date('Y') - intval($year_prefix . $year)) + 1;

        // Assign the age group label based on the calculated age
        if ($age >= 20 && $age < 30) {
            $ageGroup = "20s";
        } elseif ($age >= 30 && $age < 40) {
            $ageGroup = "30s";
        } elseif ($age >= 40 && $age < 50) {
            $ageGroup = "40s";
        } elseif ($age >= 50 && $age < 60) {
            $ageGroup = "50s";
        } elseif ($age >= 60) {
            $ageGroup = "60s";
        }

        // Increment the count for the corresponding age group and sex
        $tableData[$ageGroup][$sex] += $count;
    }

    // Generate the table HTML
    echo '<h2>Number of Patients by Age Group and Gender (Table)</h2>';
    echo '<table>';
    echo '<tr>';
    echo '<th>Age Group</th>';
    echo '<th>Sex</th>';
    echo '<th>Number of Patients</th>';
    echo '</tr>';

    foreach ($ageGroups as $ageGroup) {
        echo '<tr>';
        echo '<td>' . $ageGroup . '</td>';
        echo '<td>F</td>';
        echo '<td>' . $tableData[$ageGroup]['F'] . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td></td>';
        echo '<td>M</td>';
        echo '<td>' . $tableData[$ageGroup]['M'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}


?>



<!DOCTYPE html>
<html>
<head>
    <title>Patient Data</title>
    
</head>
<body>
		
    <h1>Patient Data</h1>
    <form method="POST" action="">
        <input type="hidden" name="action" value="chart">
        <input type="submit" value="Generate Chart">
        
    </form>
    <form method="POST" action="">
    		<input type="hidden" name="action" value="table">
    		<input type="submit" value="Generate Table">
		</form>
		<form method="POST" action="">
    		<input type="hidden" name="action" value="day">
    		<input type="submit" value="Generate Date Chart">
		</form>
    
		<form method="POST" action="nurse_page.php">
    		<input type="submit" value="Go to Nurse Page">
		</form>
		
</body>
</html>



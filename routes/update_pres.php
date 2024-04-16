<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect("localhost:3307", "web", "web_admin", "company");
    if (!$conn) {
        echo "Database Connection Error!!";
        exit();
    }

    $cno = $_POST['cno']; // 수정할 레코드의 식별자
    $newPres = $_POST['new_pres']; // 새로운 'pres' 데이터

    $query = "UPDATE CHART SET PRES = '$newPres' WHERE CNO = '$cno';";

    if (mysqli_query($conn, $query)) {
        echo "Pres updated successfully.";
    } else {
        echo "Error updating pres: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

echo "<br>";
echo "<form action='doctor_page.php'>";
echo "<input type='submit' value='Go to Doctor Page'>";
echo "</form>";

echo "<br>";
echo "<form action='nurse_page.php'>";
echo "<input type='submit' value='Go to Nurse Page'>";
echo "</form>";
?>
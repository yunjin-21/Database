<?php
// MySQL 데이터베이스 연결 설정
$servername = "localhost:3307";
$username = "web";
$password = "web_admin";
$dbname = "company";


// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}

// POST 요청 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 웹 폼에서 전달된 환자 정보 수집
    $pid = $_POST["pid"]; // 수정된 부분: "PID" 대신 "pid"로 변경
    $sex = $_POST["sex"]; // 수정된 부분: "SEX" 대신 "sex"로 변경
    $name = $_POST["name"]; // 수정된 부분: "NAME" 대신 "name"으로 변경
    $email = $_POST["email"]; // 수정된 부분: "EMAIL" 대신 "email"로 변경
    $job = $_POST["job"]; // 수정된 부분: "JOB" 대신 "job"으로 변경
    $resid = $_POST["resid"]; // 수정된 부분: "RESID" 대신 "resid"로 변경
    $tel = $_POST["tel"]; // 수정된 부분: "TEL" 대신 "tel"로 변경
    $address = $_POST["address"]; // 수정된 부분: "ADDRESS" 대신 "address"로 변경
    $mandoc = $_POST["mandoc"]; // 수정된 부분: "MANDOC" 대신 "mandoc"으로 변경
    $mannur = $_POST["mannur"]; // 수정된 부분: "MANNUR" 대신 "mannur"으로 변경

    // 환자 정보를 데이터베이스에 추가하기 전에 중복 확인
    $check_query = "SELECT * FROM PATIENT WHERE PID='$pid'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "이미 해당 PID를 가진 환자가 데이터베이스에 존재합니다.";
    } else {
        // 환자 정보를 데이터베이스에 추가하는 SQL 쿼리
        $insert_query = "INSERT INTO PATIENT (PID, SEX, NAME, EMAIL, JOB, RESID, TEL, ADDRESS, MANDOC, MANNUR) VALUES ('$pid', '$sex', '$name', '$email', '$job', '$resid', '$tel', '$address', '$mandoc', '$mannur')";

        if ($conn->query($insert_query) === TRUE) {
            echo "새로운 환자 정보가 성공적으로 추가되었습니다.";
        } else {
            echo "오류: " . $insert_query . "<br>" . $conn->error;
        }
    }
}

$conn->close();
echo "<br>";
echo "<form action='doctor_page.php'>";
echo "<input type='submit' value='Go to Doctor Page'>";
echo "</form>";
echo "<br>";
echo "<form action='nurse_page.php'>";
echo "<input type='submit' value='Go to Nurse Page'>";
echo "</form>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>새로운 환자 추가</title>
</head>
<body>
    <h2>새로운 환자 추가</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="pid">환자 ID:</label>
        <input type="number" name="pid" required><br> <!-- 수정된 부분: "PID" 대신 "pid"로 변경 -->

        <label for="sex">성별:</label>
        <input type="text" name="sex" maxlength="1" required><br> <!-- 수정된 부분: "SEX" 대신 "sex"로 변경 -->

        <label for="name">이름:</label>
        <input type="text" name="name" maxlength="10" required><br> <!-- 수정된 부분: "NAME" 대신 "name"으로 변경 -->

        <label for="email">이메일:</label>
        <input type="email" name="email" maxlength="50" required><br> <!-- 수정된 부분: "EMAIL" 대신 "email"로 변경 -->

        <label for="job">직업:</label>
        <input type="text" name="job" maxlength="20" required><br> <!-- 수정된 부분: "JOB" 대신 "job"으로 변경 -->

        <label for="resid">주민등록번호:</label>
        <input type="text" name="resid" maxlength="14" required><br> <!-- 수정된 부분: "RESID" 대신 "resid"로 변경 -->

        <label for="tel">전화번호:</label>
        <input type="text" name="tel" maxlength="13" required><br> <!-- 수정된 부분: "TEL" 대신 "tel"로 변경 -->

        <label for="address">주소:</label>
        <input type="text" name="address" maxlength="30" required><br> <!-- 수정된 부분: "ADDRESS" 대신 "address"로 변경 -->

        <label for="mandoc">담당 의사 ID:</label>
        <input type="number" name="mandoc" required><br> <!-- 수정된 부분: "MANDOC" 대신 "mandoc"으로 변경 -->

        <label for="mannur">담당 간호사 ID:</label>
        <input type="number" name="mannur" required><br> <!-- 수정된 부분: "MANNUR" 대신 "mannur"으로 변경 -->

        <input type="submit" value="추가">
    </form>
</body>
</html>

<HTML>
<HEAD>
<TITLE> CHART INFO </TITLE>
</HEAD>

<BODY>
<?php
$conn = mysqli_connect("localhost:3307", "web", "web_admin", "company");
if (!$conn) {
    echo "Database Connection Error!!";
} else {
    echo "Database Connection Success!!";
}
if (mysqli_connect_errno()) {
    echo "Could not connect:" . mysqli_connect_error();
    exit();
}

$query = "SELECT CNO, DISEASE, CDIG, CDOC, CNUR, CPAT, PRES FROM CHART;";
     
$result = mysqli_query($conn, $query);
?>

<TABLE BORDER=1>
    <TR>
        <TD> CNO </TD>
        <TD> DISEASE </TD>
        <TD> CDIG </TD>
        <TD> CDOC </TD>
        <TD> CNUR </TD>
        <TD> CPAT </TD>
        <TD> PRES </TD>
        <TD> PRES_REWRITE </TD> <!-- 추가된 열 -->
        <TD> DISEASE_REWRITE </TD> 
    </TR>
    <?php
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <TR>
            <TD> <?= $row['CNO'] ?></TD>
            <TD> <?= $row['DISEASE'] ?></TD>
            <TD> <?= $row['CDIG'] ?></TD>
            <TD> <?= $row['CDOC'] ?></TD>
            <TD> <?= $row['CNUR'] ?></TD>
            <TD> <?= $row['CPAT'] ?></TD>
            <TD> <?= $row['PRES'] ?></TD>
            <TD>
                <form method="post" action="update_pres.php"> <!-- 수정할 페이지로 연결 -->
                    <input type="hidden" name="cno" value="<?= $row['CNO'] ?>"> <!-- 수정할 데이터의 식별자(hidden 필드) -->
                    <input type="text" name="new_pres"> <!-- 수정할 데이터 입력 필드 -->
                    <input type="submit" value="Update1"> <!-- 수정 버튼 -->
                </form>
            </TD>
            <TD>
                <form method="post" action="update_disease.php"> <!-- 수정할 페이지로 연결 -->
                    <input type="hidden" name="cno" value="<?= $row['CNO'] ?>"> <!-- 수정할 데이터의 식별자(hidden 필드) -->
                    <input type="text" name="new_disease"> <!-- 수정할 데이터 입력 필드 -->
                    <input type="submit" value="Update2"> <!-- 수정 버튼 -->
                </form>
            </TD>
        </TR>
    <?php } ?>
</TABLE>

</BODY>
</HTML>

<HTML>
<HEAD>
<TITLE> PATIENT INFO </TITLE>
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

$query = "SELECT PID, SEX, NAME, EMAIL, JOB, RESID, TEL, ADDRESS, MANDOC, MANNUR FROM PATIENT"; // 쿼리 문장 끝에 세미콜론(;) 추가

$result = mysqli_query($conn, $query);
?>

<TABLE BORDER=1>
    <TR>
        <TD> PATIENT_ID </TD>
        <TD> SEX </TD>
        <TD> NAME </TD>
        <TD> EMAIL </TD>
        <TD> JOB </TD>
        <TD> RESID </TD>
        <TD> TEL </TD>
        <TD> ADDRESS </TD>
        <TD> MANDOC </TD>
        <TD> MANNUR </TD>
    </TR>
    <?php
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <TR>
            <TD> <?= $row['PID'] ?></TD>
            <TD><?= $row['SEX'] ?></TD>
            <TD><?= $row['NAME'] ?></TD>
            <TD><?= $row['EMAIL'] ?></TD>
            <TD><?= $row['JOB'] ?></TD>
            <TD><?= $row['RESID'] ?></TD>
            <TD><?= $row['TEL'] ?></TD>
            <TD><?= $row['ADDRESS'] ?></TD>
            <TD> <?= $row['MANDOC'] ?></TD>
            <TD><?= $row['MANNUR'] ?></TD>
        </TR>
    <?php } ?>
</TABLE>

</FORM>
<?php
mysqli_free_result($result);
mysqli_close($conn);
?>
</BODY>
</HTML>

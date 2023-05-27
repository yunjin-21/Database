<HTML>
<HEAD>
<TITLE> PATIENT INFO </TITLE>
</HEAD>

<BODY>
<?php
$conn = mysqli_connect("localhost:3307", "web", "web_admin", "patient");
if (!$conn) {
    echo "Database Connection Error!!";
} else {
    echo "Database Connection Success!!";
}
if (mysqli_connect_errno()) {
    echo "Could not connect:" . mysqli_connect_error();
    exit();
}

$query = "SELECT P.PID, P.SEX, P.NAME, P.EMAIL, P.JOB, P.RESID, P.TEL, P.ADDRESS, D.NAME AS MANDOC, N.NAME AS MANNUR FROM PATIENT P
          LEFT JOIN DOCTOR D ON P.MANDOC = D.DID
          LEFT JOIN NURSE N ON P.MANNUR = N.NID";
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

<HTML>
<HEAD>
<TITLE> CHART INFO </TITLE>
</HEAD>

<BODY>
<?php
$conn = mysqli_connect("localhost:3307", "web", "web_admin", "chart");
if (!$conn) {
    echo "Database Connection Error!!";
} else {
    echo "Database Connection Success!!";
}
if (mysqli_connect_errno()) {
    echo "Could not connect:" . mysqli_connect_error();
    exit();
}

$query = "SELECT C.CNO, C.DISEASE, MC.SYMPTOM, MC.VDATE, D.NAME AS CDOC, N.NAME AS CNUR, P.NAME AS CPAT, C.PRES
          FROM CHART C
          LEFT JOIN MediCer MC ON C.CDIG = MC.DIGID
          LEFT JOIN DOCTOR D ON C.CDOC = D.DID
          LEFT JOIN NURSE N ON C.CNUR = N.NID
          LEFT JOIN PATIENT P ON C.CPAT = P.PID";
$result = mysqli_query($conn, $query);
?>

<TABLE BORDER=1>
    <TR>
        <TD> CNO </TD>
        <TD> DISEASE </TD>
        <TD> SYMPTOM </TD>
        <TD> VDATE </TD>
        <TD> CDOC </TD>
        <TD> CNUR </TD>
        <TD> CPAT </TD>
        <TD> PRES </TD>
    </TR>
    <?php
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <TR>
            <TD> <?= $row['CNO'] ?></TD>
            <TD> <?= $row['DISEASE'] ?></TD>
            <TD> <?= $row['SYMPTOM'] ?></TD>
            <TD> <?= $row['VDATE'] ?></TD>
            <TD> <?= $row['CDOC'] ?></TD>
            <TD> <?= $row['CNUR'] ?></TD>
            <TD> <?= $row['CPAT'] ?></TD>
            <TD> <?= $row['PRES'] ?></TD>
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

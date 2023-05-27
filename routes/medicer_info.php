<HTML>
<HEAD>
<TITLE> MEDICER_INFO </TITLE>
</HEAD>

<BODY>
<?php
$conn = mysqli_connect("localhost:3307", "web", "web_admin", "medicier");
if(!$conn){
    echo "Database Connection Error!!";
} else {
    echo "Database Connection Success!!";
}

if(mysqli_connect_errno()) {
    echo "Could not connect: " . mysqli_connect_error();
    exit();
}

$query = "SELECT DIGID,SYMPTOM,VDATE,DOCID, DIGP FROM MEDICER";  //NOTION 이름 똑같아서 DOCID로 수정
$result = mysqli_query($conn, $query);
?>

<TABLE BORDER=1>
    <TR>
        <TD> DIGID </TD>
        <TD>  SYMPTOM </TD>
        <TD> VDATE</TD>
        <TD> DODID </TD>
        <TD> 	DIGP</TD>
      
        
    </TR>
    <?php
    while ($row = mysqli_fetch_array($result))
    {
    ?>
    <TR>
        <TD> <?=$row['DIGID']?></TD>
        <TD> <?=$row[' SYMPTOM']?></TD>
        <TD><?=$row[' VDATE']?></TD>
        <TD><?=$row['DODID']?></TD>
        <TD><?=$row['DIGP']?></TD>
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

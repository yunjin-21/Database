
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <form method="post" action="search.php">
        <input type="submit" name="search" value="Search">
    </form>

    <form method="post" action="patient_register.php">
        <input type="submit" name="patient_register" value="Patient Register">
    </form>

    <form method="post" action="analysis.php">
        <input type="submit" name="analysis" value="Analysis">
    </form>

    <form method="post" action="rewrite_chart.php">
        <input type="submit" name="rewrite_chart" value="Rewrite Chart">
    </form>
    <form method="POST" action="../login.php">
        <input type="hidden" name="action" value="logout">
        <input type="submit" value="Logout">
    </form>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    
    <form method="post" action="analysis_patient.php">
        <input type="submit" name="analysis" value="Analysis">
    </form>
    <form method="POST" action="../login.php">
        <input type="hidden" name="action" value="logout">
        <input type="submit" value="Logout">
    </form>
    
</body>
</html>

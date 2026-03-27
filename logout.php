<?php
session_start();

$_SESSION = [];
session_unset();
session_destroy();

header("Location: index.php");
exit();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">

<!-- auto redirect after 2 seconds -->
<meta http-equiv="refresh" content="2;url=index.php">
</head>
<body>

<div class="navbar">
    <div class="logo">
        <img src="logo.jpg">
        <b>DLU University</b>
    </div>
</div>

<div style="text-align:center; margin-top:100px;">

    <h2>You have been logged out successfully</h2>
    <p>Redirecting to homepage...</p>

    <div class="center-btn" style="margin-top:20px;">
        <a href="index.php" class="view-btn">Go Now</a>
    </div>

</div>

</body>
</html>
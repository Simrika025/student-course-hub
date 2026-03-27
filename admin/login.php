<?php
session_start();
$adminEmail = "admin@dlu.edu";
$adminPasswordHash = '$2y$10$usesomesillystringforexamplehashedpw1234567890abcd';
$error = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
$email = $_POST['email'];
$password = $_POST['password'];
if($email === $adminEmail && $password === "admin123"){
$_SESSION['admin_id'] = $row['AdminID'];
session_regenerate_id(true);
header("Location: dashboard.php");
exit();
 } else {
$error = "Invalid email or password";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="navbar">
<div class="logo">
<img src="../logo.jpg">
<b>DLU University</b>
</div>
<div>
<a href="../index.php">Back</a>
</div>
</div>

<h2 style="text-align:center; margin-top:40px;">Admin Login</h2>
<form method="POST" class="form-box">
<input type="email" name="email" placeholder="Enter Email" required>
<input type="password" name="password" placeholder="Enter Password" required>
<div class="center-btn">
<button type="submit" class="view-btn">Login</button>
</div>

<?php if($error != ""){ ?>
<div class="error-box" style="text-align:center; margin-top:10px;">
<?php echo $error; ?>
</div>
<?php } ?>
</form>

</body>
</html>
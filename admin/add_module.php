<?php 
include 'auth.php';
include '../config.php';
$message = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
$name = mysqli_real_escape_string($conn, $_POST['ModuleName']);
$desc = mysqli_real_escape_string($conn, $_POST['Description']);
$conn->query("
INSERT INTO Modules (ModuleName, Description)
VALUES ('$name', '$desc')
");
$message = "Module added successfully!";
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
<a href="manage_modules.php">Back</a>
</div>
</div>
<h2 style="text-align:center; margin-top:30px;">Add Module</h2>
<form method="POST" class="form-box">
<input type="text" name="ModuleName" placeholder="Module Name" required>
<textarea name="Description" placeholder="Module Description" required></textarea>
<div class="center-btn">
<button class="view-btn">Add Module</button>
</div>
<?php if($message != ""){ ?>
<p style="text-align:center; color:green; margin-top:10px;">
<?php echo $message; ?>
</p>
<?php } ?>
</form>
</body>
</html>
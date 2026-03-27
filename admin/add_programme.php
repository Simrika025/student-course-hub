<?php 
include 'auth.php';
include '../config.php';
$message = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
$name = mysqli_real_escape_string($conn, $_POST['ProgrammeName']);
$desc = mysqli_real_escape_string($conn, $_POST['Description']);
$conn->query("
INSERT INTO Programmes (ProgrammeName, Description)
VALUES ('$name', '$desc')
");
$message = "Programme added successfully!";
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
<a href="manage_programmes.php">Back</a> 
</div>
</div>
<h2 style="text-align:center; margin-top:30px;">Add Programme</h2>
<form method="POST" class="form-box">
<input type="text" name="ProgrammeName" placeholder="Programme Name" required>
<textarea name="Description" placeholder="Description" required></textarea>
<div class="center-btn">
<button class="view-btn">Add Programme</button>
</div>
<?php if($message != ""){ ?>
<p style="text-align:center; color:green; margin-top:10px;">
<?php echo $message; ?>
</p>
<?php } ?>
</form>
</body>
</html>
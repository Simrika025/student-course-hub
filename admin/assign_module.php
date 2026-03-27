<?php 
include 'auth.php';
include '../config.php';
$moduleID = intval($_GET['id']);
$message = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
$staffID = intval($_POST['staff']);
$conn->query("
UPDATE Modules 
SET ModuleLeaderID = $staffID 
WHERE ModuleID = $moduleID
");
$message = "Staff assigned successfully!";
}
$staff = $conn->query("SELECT * FROM Staff");
$module = $conn->query("SELECT ModuleName FROM Modules WHERE ModuleID = $moduleID");
$moduleData = $module->fetch_assoc();
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
<h2 style="text-align:center; margin-top:30px;">
Assign Staff to <?php echo $moduleData['ModuleName']; ?>
</h2>
<form method="POST" class="form-box">
<select name="staff" required>
<option value="">Select Staff</option>

<?php
while($row = $staff->fetch_assoc()){
echo "<option value='".$row['StaffID']."'>".htmlspecialchars($row['Name'])."</option>";
}
?>
</select>
<div class="center-btn">
<button class="view-btn">Assign</button>
</div>

<?php if($message != ""){ ?>
<p style="text-align:center; color:green; margin-top:10px;">
<?php echo $message; ?>
</p>
<?php } ?>
</form>
</body>
</html>
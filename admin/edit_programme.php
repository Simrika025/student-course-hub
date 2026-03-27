<?php 
include 'auth.php';
include '../config.php';
$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM Programmes WHERE ProgrammeID = $id");
$data = $result->fetch_assoc();
if($_SERVER["REQUEST_METHOD"] == "POST"){
$name = mysqli_real_escape_string($conn, $_POST['ProgrammeName']);
$desc = mysqli_real_escape_string($conn, $_POST['Description']);
$conn->query("
UPDATE Programmes 
SET ProgrammeName='$name', Description='$desc' 
WHERE ProgrammeID=$id
");

header("Location: manage_programmes.php");
exit();
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

<h2 style="text-align:center;">Edit Programme</h2>

<form method="POST" class="form-box">
<input type="text" name="ProgrammeName" 
value="<?php echo htmlspecialchars($data['ProgrammeName']); ?>" required>
<textarea name="Description" required><?php echo $data['Description']; ?></textarea>
<div class="center-btn">
<button class="view-btn">Update</button>
</div>
</form>
</body>
</html>
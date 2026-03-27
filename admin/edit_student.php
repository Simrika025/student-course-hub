<?php 
include 'auth.php';
include '../config.php';
$id = intval($_GET['id']);
$message = "";
$result = $conn->query("SELECT * FROM InterestedStudents WHERE InterestID = $id");
$data = $result->fetch_assoc();
if($_SERVER["REQUEST_METHOD"] == "POST"){
$name = $_POST['name'];
$email = $_POST['email'];
$conn->query("
UPDATE InterestedStudents 
SET StudentName='$name', Email='$email'
WHERE InterestID=$id
");
$message = "Updated successfully!";
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
<a href="students.php">Back</a>
</div>
</div>
<h2 style="text-align:center; margin-top:30px;">Edit Student</h2>
<form method="POST" class="form-box">
<input type="text" name="name" value="<?php echo $data['StudentName']; ?>" required>
<input type="email" name="email" value="<?php echo $data['Email']; ?>" required>
<div class="center-btn">
<button class="view-btn">Update</button>
</div>

<?php if($message != ""){ ?>
<p style="text-align:center; color:green; margin-top:10px;">
<?php echo $message; ?>
</p>
<?php } ?>
</form>
</body>
</html>
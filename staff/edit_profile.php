<?php
include '../config.php';
session_start();

if(!isset($_SESSION['staff_id'])){
    die("Not logged in");
}

$staffID = $_SESSION['staff_id'];

if(isset($_POST['update'])){
$name = $_POST['name'];

if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
$fileName = time() . "_" . basename($_FILES['image']['name']);
$target = "../staff/" . $fileName;

if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
$dbPath = "staff/" . $fileName;
$stmt = $conn->prepare("
UPDATE staff 
SET image=?
WHERE StaffID=?
 ");
$stmt->bind_param("ssi", $name, $dbPath, $staffID);
 } else {
 die("Image upload failed");
 }

} else {
$stmt = $conn->prepare("
UPDATE staff 
SET Name=? 
WHERE StaffID=?
");
$stmt->bind_param("si", $name, $staffID);
}
$stmt->execute();
}

$stmt = $conn->prepare("SELECT * FROM staff WHERE StaffID=?");
$stmt->bind_param("i", $staffID);
$stmt->execute();
$result = $stmt->get_result();
$staff = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../style.css">

<style>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    width: 350px;
    margin: auto;
    text-align: center;
    padding: 20px;
}

.card input {
    width: 90%;
    margin: 10px auto;
    display: block;
    padding: 8px;
}


input[type="file"] {
    display: block;
    margin: 10px auto;
}


.profile-img {
    width: 150px;
    display: block;
    margin: 10px auto;
    border-radius: 10px;
}
</style>

</head>
<body>

<div class="navbar">
<div class="logo">
<img src="../logo.jpg">
<b>DLU University</b>
</div>
<div>
<a href="dashboard.php">Back</a>
</div>
</div>

<h2 style="text-align:center;">Edit Profile</h2>
<div class="container">

<form method="POST" enctype="multipart/form-data" class="card">
<img src="<?php echo !empty($staff['Image']) ? '../'.$staff['Image'] : '../staff/default.jpg'; ?>" 
class="profile-img">

<label>Name</label>
<input type="text" name="name" 
value="<?php echo htmlspecialchars($staff['Name']); ?>" required>

<label>Email</label>
<input type="email" 
value="<?php echo htmlspecialchars($staff['Email']); ?>" readonly>

<label>Change Image</label>
<input type="file" name="image">
<br>
<button type="submit" name="update" class="view-btn">Update Profile</button>
<br><br>
<a href="../change_password.php" class="view-btn">Change Password</a>
</form>
</div>

</body>
</html>
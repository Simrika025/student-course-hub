<?php
session_start();
include 'config.php';

if(!isset($_SESSION['role'])){
die("Not logged in");
}
$role = $_SESSION['role'];

if($role == 'staff'){
$table = 'staff';
$idField = 'StaffID';
$id = $_SESSION['staff_id'];
}

elseif($role == 'admin'){
$table = 'admin';
$idField = 'AdminID';
$id = $_SESSION['admin_id'];
}

elseif($role == 'student'){
$table = 'students';
$idField = 'StudentID';
$id = $_SESSION['student_id'];
}
else{
    die("Invalid role");
}

if(isset($_POST['update'])){
$current = $_POST['current_password'];
$new = $_POST['new_password'];
$confirm = $_POST['confirm_password'];
$stmt = $conn->prepare("SELECT Password FROM $table WHERE $idField=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if(!password_verify($current, $result['Password'])){
$error = "Current password is incorrect";
}

elseif($new !== $confirm){
$error = "Passwords do not match";
}
else{
$hashed = password_hash($new, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE $table SET Password=? WHERE $idField=?");
$stmt->bind_param("si", $hashed, $id);
$stmt->execute();
$success = "Password updated successfully";

if($role == 'admin'){
echo "<script>
setTimeout(function(){
window.location.href = 'admin/profile.php';
}, 2000);
</script>";
}

elseif($role == 'staff'){
echo "<script>
setTimeout(function(){
window.location.href = 'staff/dashboard.php';
}, 2000);
</script>";
 }
   
 else{
echo "<script>
setTimeout(function(){
window.location.href = 'student/dashboard.php';
}, 2000);
</script>";
}
}
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
<div class="logo">
<img src="logo.jpg">
<b>DLU University</b>
</div>
</div>

<h2 style="text-align:center;">Change Password</h2>

<div class="container">
<form method="POST" class="card" style="max-width:350px; margin:auto; text-align:center;">
<input type="password" name="current_password" placeholder="Current Password" required>
<input type="password" name="new_password" placeholder="New Password" required>
<input type="password" name="confirm_password" placeholder="Confirm New Password" required>

<button type="submit" name="update" class="view-btn">Update Password</button>
<?php if(isset($error)){ ?>
<p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<?php if(isset($success)){ ?>
<p style="color:green;"><?php echo $success; ?></p>
<?php } ?>
</form>
</div>

</body>
</html>
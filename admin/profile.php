<?php
session_start();
include '../config.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

if(!isset($_SESSION['admin_id'])){
    die("Admin not logged in properly");
}

$adminID = $_SESSION['admin_id'];

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $target = "../admin/" . $fileName;

        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){

            $dbPath = "admin/" . $fileName;

            $stmt = $conn->prepare("
                UPDATE admin 
                SET Name=?, Email=?, Image=? 
                WHERE AdminID=?
            ");
            $stmt->bind_param("sssi", $name, $email, $dbPath, $adminID);

        } else {
            die("Image upload failed");
        }

    } else {
        $stmt = $conn->prepare("
            UPDATE admin 
            SET Name=?, Email=? 
            WHERE AdminID=?
        ");
        $stmt->bind_param("ssi", $name, $email, $adminID);
    }

    $stmt->execute();
}

$stmt = $conn->prepare("SELECT * FROM admin WHERE AdminID=?");
$stmt->bind_param("i", $adminID);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
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
<a href="dashboard.php">Back</a>
</div>
</div>

<h2 style="text-align:center; margin-top:30px;">My Profile</h2>
<div class="center-wrapper">
<form method="POST" enctype="multipart/form-data" class="form-box">
<img src="<?php echo !empty($admin['Image']) ? '../'.$admin['Image'] : '../admin/default.jpg'; ?>" 
style="width:150px; height:150px; object-fit:cover; border-radius:10px; display:block; margin:auto;">
<input type="text" name="name" 
value="<?php echo htmlspecialchars($admin['Name']); ?>" required>
<input type="email" name="email" 
value="<?php echo htmlspecialchars($admin['Email']); ?>" required>

<label>Change Image</label>
<input type="file" name="image">

<div class="center-btn">
<button type="submit" name="update" class="view-btn">Update Profile</button>
</div>
</form>

<div class="center-btn" style="margin-top:15px;">
<a href="../change_password.php">Change Password</a>
</div>
</div>

</body>
</html>
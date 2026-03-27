<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // ADMIN
    $stmt = $conn->prepare("SELECT * FROM admin WHERE Email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $admin = $stmt->get_result();

    if ($admin->num_rows > 0) {
    $row = $admin->fetch_assoc();
    if (password_verify($password, $row['Password'])) {
        $_SESSION['role'] = 'admin';
        $_SESSION['admin_id'] = $row['AdminID'];
        header("Location: admin/dashboard.php");
        exit();
    }
}

    // STAFF
    $stmt = $conn->prepare("SELECT * FROM staff WHERE Email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $staff = $stmt->get_result();

    if ($staff->num_rows > 0) {
        $row = $staff->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            $_SESSION['role'] = 'staff';
            $_SESSION['staff_id'] = $row['StaffID'];
            header("Location: staff/dashboard.php");
            exit();
        }
    }

    // STUDENT
    $stmt = $conn->prepare("SELECT * FROM students WHERE Email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $student = $stmt->get_result();

    if ($student->num_rows > 0) {
        $row = $student->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            $_SESSION['role'] = 'student';
            $_SESSION['student_id'] = $row['StudentID'];
            header("Location: student/dashboard.php");
            exit();
        }
    }

    echo "Invalid email or password!";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <div class="logo">
        <img src="logo.jpg">
        <b>DLU University</b>
    </div>
    <div>
        <a href="index.php">Home</a>
    </div>
</div>

<h2 style="text-align:center; margin-top:40px;">Login</h2>

<div class="center-wrapper">

<form method="POST" class="form-box">

    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <div class="center-btn">
        <button type="submit" class="view-btn">Login</button>
    </div>

    <?php if(isset($error)){ ?>
        <p style="text-align:center; color:red;">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php } ?>

</form>
<p style="text-align:center;">
    Don't have an account?
    <a href="signup.php">Register</a>
</p>

</div>

</body>
</html>
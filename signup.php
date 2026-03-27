<?php
include 'config.php';

$message = "";
$success = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = trim($_POST['name']);
    $email = strtolower(trim($_POST['email']));
    $passwordInput = $_POST['password'];

    if(empty($name)){
        $message = "Full name is required!";
    }
    elseif(strlen($name) < 3){
        $message = "Full name must be at least 3 characters!";
    }
    elseif(!preg_match("/^[a-zA-Z ]+$/", $name)){
        $message = "Name can only contain letters and spaces!";
    }
    elseif(empty($email)){
        $message = "Email is required!";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $message = "Invalid email format!";
    }
    elseif(empty($passwordInput)){
        $message = "Password is required!";
    }
    elseif(strlen($passwordInput) < 6){
        $message = "Password must be at least 6 characters!";
    }
    else{

        $name = $conn->real_escape_string($name);
        $password = password_hash($passwordInput, PASSWORD_DEFAULT);

        $check = $conn->query("SELECT * FROM students WHERE Email='$email'");

        if($check->num_rows > 0){
            $message = "Email already registered!";
        } else {

            $conn->query("
            INSERT INTO students (StudentName, Email, Password)
            VALUES ('$name', '$email', '$password')
            ");

            $success = true;
            header("Location: login.php");
            exit();
        }
    }
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
        <a href="login.php">Back</a>
    </div>
</div>

<h2 style="text-align:center;">Student Register</h2>

<div class="center-wrapper">

<form method="POST" class="form-box">

    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <div class="center-btn">
        <button type="submit" class="view-btn">Register</button>
    </div>

    <p style="text-align:center; color:red;">
        <?php echo htmlspecialchars($message); ?>
    </p>

</form>

</div>

</body>
</html>
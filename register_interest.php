<?php
include("config.php");

if(!isset($_GET['id']) && !isset($_POST['programme_id'])){
    die("Programme not selected");
}

$programmeID = isset($_POST['programme_id']) 
    ? intval($_POST['programme_id']) 
    : intval($_GET['id']);

$message = "";
$type = "";
$success = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = trim($_POST['name']);
    $email = strtolower(trim($_POST['email']));

    if(empty($name) || empty($email)){
        $message = "All fields are required!";
        $type = "error";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $message = "Invalid email format!";
        $type = "error";
    }
    else{

        $stmt = $conn->prepare("SELECT * FROM interestedstudents WHERE Email=? AND ProgrammeID=?");
        $stmt->bind_param("si", $email, $programmeID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "You already registered interest!";
            $type = "error";
        } else {

            $stmt = $conn->prepare("INSERT INTO interestedstudents (ProgrammeID, StudentName, Email) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $programmeID, $name, $email);
            $stmt->execute();

            $message = "Interest registered successfully!";
            $type = "success";
            $success = true;
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
        <a href="programmes.php">See Other Courses</a>
    </div>
</div>

<h2 style="text-align:center;">Register Your Interest</h2>

<div class="center-wrapper">

    <?php if($message != ""){ ?>
        <div style="text-align:center; color:<?php echo $type == 'success' ? 'green' : 'red'; ?>;">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php } ?>

    <?php if(!$success){ ?>
        <form method="POST" class="form-box">

            <input type="hidden" name="programme_id" value="<?php echo $programmeID; ?>">

            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>

            <div class="center-btn">
                <button type="submit" class="view-btn">Register Interest</button>
            </div>

        </form>
    <?php } ?>

</div>

</body>
</html>
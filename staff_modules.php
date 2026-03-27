<?php 
include 'config.php';

if(!isset($_GET['id'])){
    die("No staff selected");
}

$staffID = intval($_GET['id']);


$staffResult = $conn->query("SELECT * FROM Staff WHERE StaffID = $staffID");

if($staffResult->num_rows == 0){
    die("Staff not found");
}

$staff = $staffResult->fetch_assoc();
$name = $staff['Name'];


$image = !empty($staff['Image']) 
    ? $staff['Image'] 
    : "staff/default.jpg";
    


$email = $staff['Email'];


$modules = $conn->query("
    SELECT ModuleName, Description 
    FROM Modules 
    WHERE ModuleLeaderID = $staffID
");
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
    <a href="staff.php">Back</a>
</div>
</div>

<div style="text-align:center; margin-top:30px;">

    <img src="<?php echo $image; ?>" 
         style="width:200px; height:200px; object-fit:cover; border-radius:50%;">

    <h1><?php echo htmlspecialchars($name); ?></h1>

    <p>
        Email - <a href="mailto:<?php echo htmlspecialchars( $email); ?>">
        <?php echo $email; ?>
        </a>
    </p>

</div>

<div class="container">

<?php
if($modules->num_rows == 0){
    echo "<p style='text-align:center;'>No modules found for this staff.</p>";
}

while($row = $modules->fetch_assoc()){
    echo "<div class='card'>";
    echo "<h2>".htmlspecialchars($row['ModuleName'])."</h2>";
    echo "<p>".htmlspecialchars($row['Description'])."</p>";
    echo "</div>";
}
?>

</div>

</body>
</html>
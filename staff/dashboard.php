<?php
include '../config.php';
session_start();

if(!isset($_SESSION['staff_id'])){
    die("Not logged in");
}

$staffID = $_SESSION['staff_id'];

$stmt0 = $conn->prepare("SELECT Name, Image FROM staff WHERE StaffID=?");
$stmt0->bind_param("i", $staffID);
$stmt0->execute();
$staffData = $stmt0->get_result()->fetch_assoc();

$stmt1 = $conn->prepare("
SELECT ModuleName, Description 
FROM modules 
WHERE ModuleLeaderID = ?
");
$stmt1->bind_param("i", $staffID);
$stmt1->execute();
$modules = $stmt1->get_result();

$stmt2 = $conn->prepare("
SELECT DISTINCT p.ProgrammeName
FROM programmes p
JOIN programmemodules pm ON p.ProgrammeID = pm.ProgrammeID
JOIN modules m ON pm.ModuleID = m.ModuleID
WHERE m.ModuleLeaderID = ?
");
$stmt2->bind_param("i", $staffID);
$stmt2->execute();
$programmes = $stmt2->get_result();

$stmt3 = $conn->prepare("
SELECT DISTINCT i.StudentName, i.Email, p.ProgrammeName
FROM interestedstudents i
JOIN programmes p ON i.ProgrammeID = p.ProgrammeID
JOIN programmemodules pm ON p.ProgrammeID = pm.ProgrammeID
JOIN modules m ON pm.ModuleID = m.ModuleID
WHERE m.ModuleLeaderID = ?
ORDER BY p.ProgrammeName, i.StudentName
");
$stmt3->bind_param("i", $staffID);
$stmt3->execute();
$students = $stmt3->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport"content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../style.css">
<style>
.container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
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
        
    <a href="edit_profile.php">My Profile</a>
    <a href="../logout.php">Log out</a>
</div>
</div>

<h2 style="text-align:center; margin-top:20px;">Staff Dashboard</h2>

<div class="container">
    <div class="card" style="max-width:250px; text-align:center;">
        <img src="<?php echo !empty($staffData['Image']) ? '../'.$staffData['Image'] : '../staff/default.jpg'; ?>" style="width:100%; height:150px; object-fit:cover;">
        <h3><?php echo htmlspecialchars($staffData['Name']); ?></h3>
        <p style="color:gray;">Staff Member</p>
    </div>
</div>

<h3 style="text-align:center;">Modules I Lead</h3>

<div class="container">
<?php
if($modules->num_rows == 0){
    echo "<p style='text-align:center;'>No modules assigned</p>";
}

while($row = $modules->fetch_assoc()){
    echo "<div class='card'>";
    echo "<h3>".htmlspecialchars($row['ModuleName'])."</h3>";
    echo "<p>".htmlspecialchars($row['Description'])."</p>";
    echo "</div>";
}
?>
</div>

<h3 style="text-align:center;">Programmes Using My Modules</h3>

<div class="container">
<?php
if($programmes->num_rows == 0){
    echo "<p style='text-align:center;'>No programmes found</p>";
}

while($row = $programmes->fetch_assoc()){
    echo "<div class='card'>";
    echo "<h3>".htmlspecialchars($row['ProgrammeName'])."</h3>";
    echo "</div>";
}
?>
</div>

<h3 style="text-align:center;">Interested Students</h3>

<div class="container">
<?php
if($students->num_rows == 0){
    echo "<p style='text-align:center;'>No students found</p>";
}

while($row = $students->fetch_assoc()){
    echo "<div class='card'>";
    echo "<h3>".htmlspecialchars($row['StudentName'])."</h3>";
    echo "<p>".htmlspecialchars($row['Email'])."</p>";
    echo "<p style='color:gray;'>Programme: ".htmlspecialchars($row['ProgrammeName'])."</p>";
    echo "</div>";
}
?>
</div>

</body>
</html>
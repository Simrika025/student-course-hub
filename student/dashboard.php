<?php
session_start();
include '../config.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}

$studentID = $_SESSION['student_id'];

$stmt = $conn->prepare("SELECT Email FROM students WHERE StudentID=?");
$stmt->bind_param("i", $studentID);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows == 0){
    die("Student not found");
}

$student = $res->fetch_assoc();
$email = $student['Email'];

$stmt = $conn->prepare("
SELECT 
    i.InterestID,
    p.ProgrammeName,
    m.ModuleName,
    s.Name AS Lecturer
FROM InterestedStudents i
JOIN Programmes p ON i.ProgrammeID = p.ProgrammeID
LEFT JOIN ProgrammeModules pm ON p.ProgrammeID = pm.ProgrammeID
LEFT JOIN Modules m ON pm.ModuleID = m.ModuleID
LEFT JOIN Staff s ON m.ModuleLeaderID = s.StaffID
WHERE i.Email = ?
ORDER BY p.ProgrammeName, pm.Year
");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../style.css">
<title>Dashboard</title>
</head>
<body>

<div class="navbar">
  <div class="logo">
    <img src="../logo.jpg">
    <b>DLU University</b>
  </div>
  <div>
    <a href="../programmes.php">Other Courses</a>
    <a href="../logout.php">Logout</a>
  </div>
</div>

<h2 style="text-align:center;">My Courses</h2>

<div class="container">

<?php
$currentProgramme = "";

while($row = $result->fetch_assoc()){

    if($currentProgramme != $row['ProgrammeName']){

        if($currentProgramme != ""){
            echo "</div>";
        }

        echo "<div class='card'>";
        echo "<h3>" . htmlspecialchars($row['ProgrammeName']) . "</h3>";

        echo "<div class='center-btn' style='margin-bottom:10px;'>
        <button class='view-btn' onclick='openConfirm(" . $row['InterestID'] . ")'>
        Withdraw Interest
        </button>
        </div>";

        echo "<h4>Modules:</h4>";

        $currentProgramme = $row['ProgrammeName'];
    }

    if($row['ModuleName']){
        echo "<p>" . htmlspecialchars($row['ModuleName']) . 
        " (Lecturer: " . htmlspecialchars($row['Lecturer'] ?? "Not Assigned") . ")</p>";
    }
}

if($currentProgramme != ""){
    echo "</div>";
}
?>

</div>

<div id="confirmBox" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
  <div style="background:white; padding:20px; width:300px; margin:150px auto; text-align:center; border-radius:10px;">
    <h3>Confirm Withdrawal</h3>
    <p>Are you sure you want to withdraw?</p>
    <div class="button-group">
      <a id="confirmBtn" class="view-btn">Yes</a>
      <button onclick="closeConfirm()" class="view-btn">No</button>
    </div>
  </div>
</div>

<script>
function openConfirm(id){
    document.getElementById("confirmBox").style.display = "block";
    document.getElementById("confirmBtn").href = "../withdraw.php?id=" + id;
}

function closeConfirm(){
    document.getElementById("confirmBox").style.display = "none";
}
</script>

</body>
</html>
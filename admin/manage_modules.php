<?php 
include 'auth.php';
include '../config.php';

$result = $conn->query("
SELECT m.ModuleID, m.ModuleName, m.Description, s.Name 
FROM modules m
LEFT JOIN staff s ON m.ModuleLeaderID = s.StaffID
");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../style.css">

<style>
.button-group {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
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

<h2 style="text-align:center; margin-top:30px;">Manage Modules</h2>
<div class="center-btn">
<a href="add_module.php" class="view-btn">Add Module</a>
</div>

<div class="container">

<?php
while($row = $result->fetch_assoc()){
echo "<div class='card'>";
echo "<h3>".htmlspecialchars($row['ModuleName'])."</h3>";
echo "<p>".htmlspecialchars($row['Description'])."</p>";
if($row['Name']){
echo "<p style='text-align:center;'>Lecturer: <b>".htmlspecialchars($row['Name'])."</b></p>";
} else {
echo "<p style='text-align:center; color:red;'>No Lecturer Assigned</p>";
}
echo "<div class='button-group'>";
echo "<a href='assign_module.php?id=".$row['ModuleID']."' class='view-btn'>Assign / Reassign</a>";
echo "</div>";
echo "</div>";
}
?>
</div>
</body>
</html>
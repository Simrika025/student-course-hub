<?php 
include 'config.php';

if(!isset($_GET['id'])){
    die("No programme selected");
}

$programmeID = intval($_GET['id']);

$stmt = $conn->prepare("
SELECT p.*, l.LevelName 
FROM programmes p
LEFT JOIN levels l ON p.LevelID = l.LevelID
WHERE p.ProgrammeID=?
");
$stmt->bind_param("i", $programmeID);
$stmt->execute();
$p = $stmt->get_result();

if($p->num_rows == 0){
    die("Programme not found");
}

$programme = $p->fetch_assoc();


$sql = "
SELECT 
    m.ModuleID,
    m.ModuleName, 
    m.Description, 
    pm.Year,
    s.StaffID, 
    s.Name AS StaffName,
    (SELECT COUNT(*) FROM programmemodules WHERE ModuleID = m.ModuleID) AS usage_count
FROM programmemodules pm
JOIN modules m ON pm.ModuleID = m.ModuleID
LEFT JOIN staff s ON m.ModuleLeaderID = s.StaffID
WHERE pm.ProgrammeID = ?
ORDER BY pm.Year, m.ModuleID
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $programmeID);
$stmt->execute();
$modules = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <a href="programmes.php">Back</a>
</div>

<h1 style="text-align:center;">
<?php echo htmlspecialchars($programme['ProgrammeName']); ?>
</h1>


<p style="text-align:center; font-weight:bold;">
<?php echo htmlspecialchars($programme['LevelName']); ?>
</p>

<div class="container">

<?php
if($modules->num_rows == 0){
    echo "<p style='text-align:center;'>No modules found</p>";
}

while($row = $modules->fetch_assoc()){

    echo "<div class='card'>";
    echo "<h3>".htmlspecialchars($row['ModuleName'])."</h3>";

    
    if($programme['LevelName'] == "Postgraduate"){
        echo "<p><b>Level:</b> Postgraduate (Year ".$row['Year'].")</p>";
    } else {
        echo "<p><b>Year:</b> ".$row['Year']."</p>";
    }

    // SHARED MODULE
    if($row['usage_count'] > 1){
        echo "<p style='color:green; font-weight:bold;'>Shared Module</p>";
    }

    // LECTURER
    echo "<p><b>Lecturer - </b>";

    if($row['StaffID']){
        echo "<a href='staff_modules.php?id=".$row['StaffID']."'>"
            .htmlspecialchars($row['StaffName'])."</a>";
    } else {
        echo "Not Assigned";
    }

    echo "</p>";

    echo "<p>".htmlspecialchars($row['Description'])."</p>";

    echo "</div>";
}
?>

</div>

<div class="center-btn">
    <a class="view-btn" href="register_interest.php?id=<?php echo $programmeID; ?>">
        Register Interest
    </a>
</div>

</body>
</html>
<?php 
include 'config.php';
session_start();
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
        <a href="index.php">Back</a>
    </div>
</div>

<h1 style="text-align:center; margin-top:30px;">Our Courses</h1>


<div class="center-btn">
    <a href="programmes.php?level=1" class="view-btn">Undergraduate</a>
    <a href="programmes.php?level=2" class="view-btn">Postgraduate</a>
</div>

<form method="GET" style="text-align:center; margin:20px;">
    <input type="hidden" name="level" value="<?php echo isset($_GET['level']) ? intval($_GET['level']) : 1; ?>">
    <input type="text" name="search" placeholder="Search programmes..." 
        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button type="submit">Search</button>
</form>

<div class="course-container">

<?php

$level = isset($_GET['level']) ? intval($_GET['level']) : 1;
$search = isset($_GET['search']) ? $_GET['search'] : "";


$query = "SELECT * FROM programmes WHERE LevelID = ? AND is_published = 1";

$params = [$level];
$types = "i";


if(!empty($search)){
    $query .= " AND ProgrammeName LIKE ?";
    $searchParam = "%" . $search . "%";
    $params[] = $searchParam;
    $types .= "s";
}


$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if(!$result){
    die("Error: " . $conn->error);
}

if($result->num_rows == 0){
    echo "<p style='text-align:center;'>No courses found</p>";
}


while($row = $result->fetch_assoc()){

    $id = intval($row['ProgrammeID']);

    echo "<div class='card'>";

    echo "<h3>".htmlspecialchars($row['ProgrammeName'])."</h3>";
    echo "<p>".htmlspecialchars($row['Description'])."</p>";

    echo "<div class='center-btn'>";
    echo "<a href='programme_modules.php?id=$id' class='view-btn'>View</a>";
    echo "</div>";

    echo "</div>";
}
?>

</div>

</body>
</html>
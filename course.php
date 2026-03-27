<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
<div><b>DLU University</b></div>
<div>
<a href="index.php">Home</a>
     </div>
       </div>

<h1 style="text-align:center; margin-top:20px;">
<?php echo ($_GET['level']==1) ? "Undergraduate Courses" : "Postgraduate Courses"; ?></h1>

<form method="GET" class="form">
   <input type="hidden" name="level" value="<?php echo $_GET['level']; ?>">
     <input type="text" name="search" placeholder="Search programmes">
       <button class="btn">Search</button>
          </form>

<div class="container">
<?php
$level = $_GET['level'];
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM Programmes WHERE LevelID=$level";

if(!empty($search)){
$sql .= " AND ProgrammeName LIKE '%$search%'";
}
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
echo "<div class='card'>";
echo "<img src='".($row['Image'] ? $row['Image'] : "https://via.placeholder.com/300")."'>";
echo "<h2>".$row['ProgrammeName']."</h2>";
echo "<p>".$row['Description']."</p>";
echo "<a href='programme.php?id=".$row['ProgrammeID']."' class='btn'>View</a>";
echo "</div>";
}
?>
   </div>

</body>
</html>
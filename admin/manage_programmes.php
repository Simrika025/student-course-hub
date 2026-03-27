<?php 
include 'auth.php';
include '../config.php';

$result = $conn->query("SELECT * FROM Programmes");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../style.css">
</head>
<style>
    .button-group {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
}
</style>
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

<h2 style="text-align:center; margin-top:30px;">Manage Programmes</h2>
<div class="center-btn">
<a href="add_programme.php" class="view-btn">Add Programme</a>
</div>

<div class="container">

<?php
$published = isset($_SESSION['published']) ? $_SESSION['published'] : [];
while($row = $result->fetch_assoc()){
$id = $row['ProgrammeID'];
$isPublished = isset($published[$id]) ? $published[$id] : true;
echo "<div class='card'>";
echo "<h3>".htmlspecialchars($row['ProgrammeName'])."</h3>";
echo "<p>".htmlspecialchars($row['Description'])."</p>";
echo "<p style='text-align:center;'>Status: <b>".($isPublished ? "Published" : "Hidden")."</b></p>";
echo "<div class='button-group'>";
echo "<a href='edit_programme.php?id=".$id."' class='view-btn'>Edit</a>";
echo "<a href='toggle.php?id=".$id."' class='view-btn'>Toggle</a>";
echo "</div>";
echo "</div>";
}
?>
</div>

<div id="confirmBox" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
<div style="background:white; padding:20px; width:300px; margin:150px auto; text-align:center; border-radius:10px;">
<h3>Confirm Delete</h3>
<p>This will permanently delete the programme.</p>
<div class="button-group">
<a id="confirmDelete" class="view-btn">Yes</a>
<button onclick="closeBox()" class="view-btn">No</button>
</div>
</div>
</div>

<script>
function confirmDelete(url){
    document.getElementById("confirmBox").style.display = "block";
    document.getElementById("confirmDelete").href = url;
}
function closeBox(){
    document.getElementById("confirmBox").style.display = "none";
}
</script>

</body>
</html>
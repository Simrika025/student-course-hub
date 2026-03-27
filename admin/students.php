<?php 
include 'auth.php';
include '../config.php';
if(isset($_POST['update'])){
$id = intval($_POST['id']);
$name = $_POST['name'];
$email = $_POST['email'];

$stmt = $conn->prepare("
UPDATE interestedstudents 
SET StudentName=?, Email=?
WHERE InterestID=?
");
$stmt->bind_param("ssi", $name, $email, $id);
$stmt->execute();
}


$query = "
SELECT i.InterestID, p.ProgrammeName, i.StudentName, i.Email FROM interestedstudents i
JOIN programmes p ON i.ProgrammeID = p.ProgrammeID
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../style.css">

<style>
.table-container {
    width: 90%;
    margin: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ccc;
}

.button-group {
    display: flex;
    justify-content: center;
    gap: 8px;
}

input {
    padding: 5px;
    width: 90%;
}
</style>

<script>
function enableEdit(id){
document.getElementById("name_"+id).removeAttribute("readonly");
document.getElementById("email_"+id).removeAttribute("readonly");

document.getElementById("editBtn_"+id).style.display = "none";
document.getElementById("saveBtn_"+id).style.display = "inline-block";
document.getElementById("cancelBtn_"+id).style.display = "inline-block";
}

function cancelEdit(){
    location.reload();
}

function confirmDelete(url){
document.getElementById("confirmBox").style.display = "block";
document.getElementById("confirmDelete").href = url;
}

function closeBox(){
document.getElementById("confirmBox").style.display = "none";
}
</script>

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

<h2 style="text-align:center; margin-top:30px;">Interested Students</h2>
<div style="text-align:center; margin-bottom:20px;">
<a href="export.php" class="view-btn">Export Mailing List</a>
</div>

<div class="table-container">
<table>
<tr>
    <th>Programme</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>

<?php
while($row = $result->fetch_assoc()){
$id = intval($row['InterestID']);

echo "<tr>";
echo "<form method='POST'>";
echo "<td>".htmlspecialchars($row['ProgrammeName'])."</td>";
echo "<td>
<input type='text' id='name_$id' name='name' value='".htmlspecialchars($row['StudentName'])."' readonly>
</td>";
echo "<td>
<input type='email' id='email_$id' name='email' value='".htmlspecialchars($row['Email'])."' readonly>
</td>";
echo "<td>
<input type='hidden' name='id' value='$id'>
<div class='button-group'>
<button type='button' id='editBtn_$id' class='view-btn'onclick='enableEdit($id)'>Edit</button>
<button type='submit' name='update' id='saveBtn_$id'class='view-btn' style='display:none;'>Save</button> 
<button type='button' id='cancelBtn_$id'class='view-btn' style='display:none;' onclick='cancelEdit()'>Cancel</button>
<a href='#' class='view-btn'onclick='confirmDelete(\"delete_student.php?id=$id\")'>Remove  </a>
</div>
</td>";
echo "</form>";
echo "</tr>";
}
?>
</table>
</div>


<div id="confirmBox" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
<div style="background:white; padding:20px; width:300px; margin:150px auto; text-align:center; border-radius:10px;">
<h3>Confirm Remove</h3>
<p>This will remove the student.</p>

<div class="button-group">
<a id="confirmDelete" class="view-btn">Yes</a>
<button onclick="closeBox()" class="view-btn">No</button>
</div>
</div>
</div>

</body>
</html>
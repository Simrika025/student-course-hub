<?php
include 'config.php';

if(isset($_GET['id'])){
$id = intval($_GET['id']);
$conn->query("DELETE FROM InterestedStudents WHERE InterestID=$id");
}
header("Location: student/dashboard.php");
exit();
?>
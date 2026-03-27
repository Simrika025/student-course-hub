<?php
include 'auth.php';
include '../config.php';

$id = intval($_GET['id']);

$conn->query("DELETE FROM InterestedStudents WHERE InterestID = $id");

header("Location: students.php");
exit();
<?php
include 'auth.php';
include '../config.php';

$id = intval($_GET['id']);

$conn->query("DELETE FROM Programmes WHERE ProgrammeID = $id");

header("Location: manage_programmes.php");
exit();
<?php
session_start();

$id = $_GET['id'];

if(!isset($_SESSION['published'])){
    $_SESSION['published'] = [];
}

if(isset($_SESSION['published'][$id])){
    $_SESSION['published'][$id] = !$_SESSION['published'][$id];
} else {
    $_SESSION['published'][$id] = false;
}

header("Location: manage_programmes.php");
<?php include 'auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../style.css">
<style>
.dashboard-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.dashboard-card {
    width: 250px;
    text-align: center;
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
<a href="../index.php">Home</a>
<a href="profile.php">My Profile</a>
<a href="../logout.php">Logout</a>
</div>
</div>
<h1 style="text-align:center; margin-top:30px;">Admin Dashboard</h1>
<div class="container dashboard-container">

<div class="card dashboard-card">
<h2>Manage Programmes</h2>
<p>Add, edit, delete courses</p>
<div class="center-btn">
<a href="manage_programmes.php" class="view-btn">Open</a>
</div>
</div>

<div class="card dashboard-card">
<h2>Manage Modules</h2>
<p>Add and assign modules</p>
<div class="center-btn">
<a href="manage_modules.php" class="view-btn">Open</a>
</div>
</div>

<div class="card dashboard-card">
<h2>Interested Students</h2>
<p>View and manage student list</p>
<div class="center-btn">
<a href="students.php" class="view-btn">View</a>
</div>
</div>
</div>

</body>
</html>
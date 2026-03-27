<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
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

<h1 style="text-align:center; margin-top:30px;">Our Staff</h1>

<div class="container">

<?php

$staffImages = [
    "Dr. Alice Johnson" => "staff/alice.jpg",
    "Dr. Brian Lee" => "staff/lee.jpg",
    "Dr. Carol White" => "staff/carol.jpg",
    "Dr. David Green" => "staff/david.jpg",
    "Dr. Emma Scott" => "staff/emma.jpg",
    "Dr. Frank Moore" => "staff/frank.jpg",
    "Dr. Grace Adams" => "staff/grace.jpg",
    "Dr. Henry Clark" => "staff/henry.jpg",
    "Dr. Irene Hall" => "staff/irin.jpg",
    "Dr. James Wright" => "staff/james.jpg",
    "Dr. Sophia Miller" => "staff/sophia.jpg",
    "Dr. Benjamin Carter" => "staff/benjamin.jpg",
    "Dr. Chloe Thompson" => "staff/choe.jpg",
    "Dr. Daniel Robinson" => "staff/danial.jpg",
    "Dr. Emily Davis" => "staff/emily.jpg",
    "Dr. Nathan Hughes" => "staff/nathan.jpg",
    "Dr. Olivia Martin" => "staff/olivia.jpg",
    "Dr. Samuel Anderson" => "staff/samual.jpg",
    "Dr. Victoria Hall" => "staff/victoria.jpg",
    "Dr. William Scott" => "staff/william.jpg"
];

$staffEmails = [
    "Dr. Alice Johnson" => "alice@dlu.edu",
    "Dr. Brian Lee" => "brian@dlu.edu",
    "Dr. Carol White" => "carol@dlu.edu",
    "Dr. David Green" => "david@dlu.edu",
    "Dr. Emma Scott" => "emma@dlu.edu",
    "Dr. Frank Moore" => "frank@dlu.edu",
    "Dr. Grace Adams" => "grace@dlu.edu",
    "Dr. Henry Clark" => "henry@dlu.edu",
    "Dr. Irene Hall" => "irene@dlu.edu",
    "Dr. James Wright" => "james@dlu.edu",
    "Dr. Sophia Miller" => "sophia@dlu.edu",
    "Dr. Benjamin Carter" => "ben@dlu.edu",
    "Dr. Chloe Thompson" => "chloe@dlu.edu",
    "Dr. Daniel Robinson" => "daniel@dlu.edu",
    "Dr. Emily Davis" => "emily@dlu.edu",
    "Dr. Nathan Hughes" => "nathan@dlu.edu",
    "Dr. Olivia Martin" => "olivia@dlu.edu",
    "Dr. Samuel Anderson" => "samuel@dlu.edu",
    "Dr. Victoria Hall" => "victoria@dlu.edu",
    "Dr. William Scott" => "william@dlu.edu"
];

$result = $conn->query("SELECT * FROM staff");

while($row = $result->fetch_assoc()){

    $name = $row['Name'];

    $image = isset($staffImages[$name]) 
        ? $staffImages[$name] 
        : "https://via.placeholder.com/300";

    $email = isset($staffEmails[$name]) 
        ? $staffEmails[$name] 
        : "noemail@dlu.edu";

    echo "<div class='card'>";
    echo "<img src='".$image."' alt='staff'>";
    echo "<h2>".$name."</h2>";
    echo "<p>Lecturer</p>";

  
    echo "<p><a href='mailto:$email'>$email</a></p>";

    echo "<a class='view-btn' href='staff_modules.php?id=".$row['StaffID']."'>View </a>";

    echo "</div>";
}
?>

</div>

</body>
</html>



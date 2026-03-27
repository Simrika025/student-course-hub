<?php
include '../config.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="mailing_list_'.date("Y-m-d").'.csv"');
$output = fopen("php://output", "w");
fputcsv($output, ['Programme        ', 'Student Name        ', 'Email']);
$query = "
SELECT p.ProgrammeName, i.StudentName, i.Email
FROM interestedstudents i
JOIN programmes p ON i.ProgrammeID = p.ProgrammeID
ORDER BY p.ProgrammeName, i.StudentName
";
$result = $conn->query($query);
while($row = $result->fetch_assoc()){
fputcsv($output, [
$row['ProgrammeName'] . "   ",
$row['StudentName'] . "   ",
$row['Email']
]);
}
fclose($output);
exit;
?>
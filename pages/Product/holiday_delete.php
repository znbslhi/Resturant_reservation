<?php
require './models/Holiday.php'; 

$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$holiday = new Holidays($msqlserver, $msqluser, $msqlpass, $msqldb);

$meta = [];
$meta['result']=$holiday->deleteHoliday($holidayID);
if ($meta['result']) {
    $meta['message']='Delete is sucsesfull for holiday id = '.$holidayID;

} else {
    $meta['message']='error in delete';
}
echo json_encode($meta);

$conn->close();
//header("Location: manage_users.php"); 
exit();
?>
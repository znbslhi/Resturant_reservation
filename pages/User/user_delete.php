<?php
require './models/User.php'; 

$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$userModel = new User($msqlserver, $msqluser, $msqlpass, $msqldb);

$meta = [];
$meta['result']=$userModel->deleteUser($userID );
if ($meta['result']) {
    $meta['message']='Delete is sucsesfull for user.id = '.$userID ;

} else {
    $meta['message']='error in delete';
}
echo json_encode($meta);

$conn->close();
//header("Location: manage_users.php"); 
exit();
?>
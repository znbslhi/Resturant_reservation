<?php
require './models/Table.php'; 

$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$table = new Tables($msqlserver, $msqluser, $msqlpass, $msqldb);

$meta = [];
$meta['result']=$table->deleteTable($tableID);
if ($meta['result']) {
    $meta['message']='Delete is sucsesfull for Table id = '.$tableID;

} else {
    $meta['message']='error in delete';
}
echo json_encode($meta);

$conn->close();
//header("Location: manage_users.php"); 
exit();
?>
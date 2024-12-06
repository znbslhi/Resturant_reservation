<?php
require './models/Restaurant.php'; 

$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$restaurant = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);

$meta = [];
$meta['result']=$restaurant->deleteRestaurant($restaurantID);
if ($meta['result']) {
    $meta['message']='Delete is sucsesfull for restaurant id = '.$restaurantID;

} else {
    $meta['message']='error in delete';
}
echo json_encode($meta);

$conn->close();
//header("Location: manage_users.php"); 
exit();
?>
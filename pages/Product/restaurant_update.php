<?php
require './models/Restaurant.php'; 

$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$restaurant = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
$meta = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $status = $_POST['status'];
    $meta['result']=$restaurant->updateRestaurant($id, $name, $location,$description,$startTime,$endTime,$status);
    if ($meta['result']) {
        $meta['message']= "restaurant edited successfully.";
        $meta['data'] = $restaurant->getrestaurant($id);   
    } else {
        $meta['message']= "Error editing user.";
    }
}
echo json_encode($meta);
$conn->close();
?>
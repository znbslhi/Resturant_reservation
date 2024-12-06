<?php
require './models/Holiday.php'; 

$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$holiday = new Holidays($msqlserver, $msqluser, $msqlpass, $msqldb);
$meta = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $restaurantId = $_POST['restaurant_id'];
    $id = $_POST['id'];
    $date = $_POST['date'];
    $meta['result']=$holiday->updateHoliday($id, $restaurantId, $date);
    if ($meta['result']) {
        $meta['message']= "holiday edited successfully for id = $id.";
        $meta['data'] = $id;   
    } else {
        $meta['message']= "Error editing user.";
    }
}
echo json_encode($meta);
$conn->close();
?>
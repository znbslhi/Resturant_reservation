<?php
require './models/Restaurant.php';
$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['name']) && isset($_POST['Location']) && isset($_POST['Description'])
    && isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['status'])) {

    $restaurantModel = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
    if(!isset($_POST['owner_id'])){
        $_POST['owner_id']=$_SESSION['id'];
    }
    $result = $restaurantModel->addRestaurant(
        $_POST['owner_id'],  
        $_POST['name'],
        $_POST['Location'],
        $_POST['Description'],
        $_POST['start_time'],
        $_POST['end_time'],
        $_POST['status']
    );

    if ($result['result'] == true) {
        echo "Restaurant ".$result['id']." sucssesfully created.";
    } else {
        echo "Error in creating Restaurant";
    }

} else {
    require_once './pages/Product/restaurant_create_form.php';
}
?>
<?php
require './models/Holiday.php';
$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['date']) && isset($_POST['restaurant_id'])){

    $holidayModel = new Holidays($msqlserver, $msqluser, $msqlpass, $msqldb);

    $result = $holidayModel->addHoliday(
        $_POST['restaurant_id'],  
        $_POST['date']
    );

    if ($result['result'] == true) {
        echo "Holiday ".$result['id']." sucssesfully created.";
    } else {
        echo "Error in creating Holiday";
    }

} else {
    require_once './pages/Product/holiday_create_form.php';
}
?>
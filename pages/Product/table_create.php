<?php
require './models/Table.php';
$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['restaurant_id']) && isset($_POST['capacity']) && isset($_POST['start_time'])
    && isset($_POST['end_time']) && isset($_POST['status'])&& isset($_POST['features']) ) {

    $Tables = new Tables($msqlserver, $msqluser, $msqlpass, $msqldb);

    $result = $Tables->addTable(
        $_POST['restaurant_id'],  
        $_POST['capacity'],
        $_POST['start_time'],
        $_POST['end_time'],
        $_POST['status'],
        $_POST['features']
    );

    if ($result['result'] == true) {
        echo "Table ".$result['id']." sucssesfully created.";
    } else {
        echo "Error in creating Restaurant";
    }

} else {
    require_once './pages/Product/table_create_form.php';
}
?>
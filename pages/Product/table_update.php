<?php
require './models/Table.php'; 

$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = new Tables($msqlserver, $msqluser, $msqlpass, $msqldb);
$meta = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $capacity = $_POST['capacity'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $status = $_POST['status'];
    $features = isset($_POST['features']) ? $_POST['features'] : [];
    $meta['result']=$table->updateTable($id, $capacity, $start_time,$end_time,$status,$features);
    if ($meta['result']) {
        $meta['message']= "table edited successfully.";
        $meta['data'] = $table->getTable($id);   
    } else {
        $meta['message']= "Error editing table.";
    }
}
echo json_encode($meta);
$conn->close();
?>
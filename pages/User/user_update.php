<?php
require './models/User.php'; 

$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userModel = new User($msqlserver, $msqluser, $msqlpass, $msqldb);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $meta = [];
    $meta['result']=$userModel->updateUser($id, $email, $user_type);
    if ($meta['result']) {
        $meta['message']= "User edited successfully.";
        $meta['data'] = $userModel->getUserById($id);   
    } else {
        $meta['message']= "Error editing user.";
    }
}
echo json_encode($meta);
$conn->close();
?>
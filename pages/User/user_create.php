<?php
require './models/User.php'; 
$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = new User($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $user_type = htmlspecialchars($_POST['user_type']);

    $result = $user->addUser($email, $password, $user_type);
    $meta = [];

    if ($result) {
        $meta['id']= $result['id'];
        $meta['message'] = "User with id ".$result['id']." successfully inserted!";
    } else {
        $meta['message'] = "error in inserting user: " . $stmt->error;
    }
    echo json_encode($meta);
    $conn->close();
}
?>

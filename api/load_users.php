<?php
// دریافت اطلاعات کاربران 
require './models/User.php'; 
$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userModel = new User($msqlserver, $msqluser, $msqlpass, $msqldb);
header('Content-Type: application/json');
if (isset($_SESSION['id'])) {
    $role =$_SESSION['role'];
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $role==0 ) {
    $where = ' WHERE user_type != 0  ORDER by user_type';//بجز ادمین
    $offset = '';
    $perpage = 2;
    $page = 1;
    if(isset($_GET['page'])) {
        $page = intval($_GET['page']);
        $offset = " LIMIT $perpage OFFSET ".(($page - 1) * $perpage);
    } else {
        $offset = " LIMIT $perpage";
    }
    if (isset($_GET['query'])) {
        $where = " WHERE email LIKE %".$_GET['query']."%";
    }
    $meta = [];
    $meta['total'] =$userModel->getTotalUsers($where);
    $meta['page'] = $page;
    $meta['totalpages'] = ceil($meta['total'] / $perpage);
    $users = $userModel->getAllUsers($where,$offset);
    if ($users->num_rows > 0) {
        $meta['data'] = mysqli_fetch_all($users, MYSQLI_ASSOC);
    } else {
        $meta['data'] = []; 
    }

    echo json_encode($meta);
}

$conn->close();
?>
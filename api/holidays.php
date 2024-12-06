<?php
require './models/Holiday.php';
$role = 0;
$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['id'])) {
    $role = $_SESSION['role'];
}

$where = '';
$offset = '';
$perpage = 2;
$page = 1;

if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
    $offset = " LIMIT $perpage OFFSET " . (($page - 1) * $perpage);
} else {
    $offset = " LIMIT $perpage";
}

if (isset($_GET['query'])) {
    $query = $conn->real_escape_string($_GET['query']);
    $where = " WHERE `DATE` LIKE '%" . $query . "%'";
}

$meta = [];
$sql = "SELECT id FROM holidays" . $where;
$result = $conn->query($sql);
$meta['total'] = $result->num_rows;
$meta['page'] = $page;
$meta['totalpages'] = ceil($meta['total'] / $perpage);

if ($role == 0) {
    $sql = "SELECT holidays.*, restaurants.NAME AS restaurant_name 
            FROM holidays 
            LEFT JOIN restaurants ON holidays.resturant_id = restaurants.id" . 
            $where . $offset;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $meta['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $meta['data'] = [];
    }
} elseif ($role == 1) {
    $owner_Id = $_SESSION['id'];
    $sql = "SELECT holidays.*, restaurants.NAME AS restaurant_name 
            FROM holidays 
            LEFT JOIN restaurants ON holidays.resturant_id = restaurants.id 
            WHERE restaurants.owner_id = $owner_Id" . 
            $where . $offset;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $meta['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $meta['data'] = [];
    }
} else {
    $meta['data'] = [];
}

echo json_encode($meta);
?>
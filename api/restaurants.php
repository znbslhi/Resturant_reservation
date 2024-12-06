<?php
require './models/Restaurant.php';
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
    $where = " WHERE `NAME` LIKE '%" . $query . "%'";
}

$meta = [];
$sql = "SELECT id FROM restaurants" . $where;
$result = $conn->query($sql);
$meta['total'] = $result->num_rows;
$meta['page'] = $page;
$meta['totalpages'] = ceil($meta['total'] / $perpage);

if ($role == 0) {
    $sql = "SELECT restaurants.*, users.email AS owner_email, COALESCE(A.reserved_counts, 0) AS reserved_counts
            FROM restaurants 
            LEFT JOIN users ON restaurants.owner_id = users.id
            LEFT JOIN (SELECT tables.resturant_id, COUNT(*) AS reserved_counts 
                       FROM reserve 
                       JOIN tables ON reserve.table_id = tables.id 
                       GROUP BY tables.resturant_id) AS A ON restaurants.id = A.resturant_id" . 
                       $where . $offset;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $meta['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $meta['data'] = [];
    }
} elseif ($role == 1) {
    $owner_Id = $_SESSION['id'];
    $sql = "SELECT restaurants.id, restaurants.NAME, restaurants.Location, restaurants.Description, restaurants.start_time, restaurants.end_time, COALESCE(A.reserved_counts, 0) AS reserved_counts
            FROM restaurants
            LEFT JOIN (SELECT tables.resturant_id, COUNT(*) AS reserved_counts 
                       FROM reserve 
                       JOIN tables ON reserve.table_id = tables.id 
                       GROUP BY tables.resturant_id) AS A ON restaurants.id = A.resturant_id" . 
            $where . $offset;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $meta['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
} else {
    $database = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
    $meta['data'] = $database->restaurantsList($where . $offset);
}

echo json_encode($meta);

?>
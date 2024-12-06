<?php
require './models/Table.php';
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
    if($role == 0){
        $where = " WHERE `restaurants`.NAME LIKE '%" . $query . "%'";
    } elseif($role == 1) {
        $where = " AND `restaurants`.NAME LIKE '%" . $query . "%'";
    }
}
$meta = [];
$sql = "SELECT `tables`.id 
        FROM `tables` 
        JOIN `restaurants` ON `tables`.resturant_id = `restaurants`.id" . $where;
$result = $conn->query($sql);
$meta['total'] = $result->num_rows;
$meta['page'] = $page;
$meta['totalpages'] = ceil($meta['total'] / $perpage);
if ($role == 0) {
    $sql = "SELECT `tables`.* , restaurants.NAME AS restaurant_name, users.email AS owner_email
    FROM 
        tables 
    JOIN 
        restaurants  ON restaurants.id = `tables`.`resturant_id`
    JOIN 
        users  ON restaurants.owner_id = users.id" . $where . $offset;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
            $meta['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $meta['data'] = [];
    }
}elseif($role == 1){
    $owner_Id = $_SESSION['id'];
    $sql = "SELECT `tables`.* , `restaurants`.NAME AS 'restaurant_name' FROM `tables` JOIN `restaurants` WHERE `tables`.`resturant_id`=`restaurants`.id AND `restaurants`.owner_id=$owner_Id".$where.$offset;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $meta['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
} else {
    $database = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
    $meta['data'] =$database->restaurantsList($where.$offset);
}
echo json_encode($meta);

?>

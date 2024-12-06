<?php
$role = 0;
require './models/Reservation.php'; 
$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_SESSION['id'])) {
    $role =$_SESSION['role'];
}
$reservationModel = new Reservation($msqlserver, $msqluser, $msqlpass, $msqldb);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $where = '';
    $offset = '';
    $perpage = 4;
    $page = 1;
    
    if (isset($_GET['page'])) {
        $page = intval($_GET['page']);
        $offset = " LIMIT $perpage OFFSET " . (($page - 1) * $perpage);
    } else {
        $offset = " LIMIT $perpage";
    }


    $meta = [];
    $meta['total'] = $reservationModel->getTotalReservations($where);
    $meta['page'] = $page;
    $meta['totalpages'] = ceil($meta['total'] / $perpage);
    $reservations = $reservationModel->getAllReservations($where, $offset);
    
    if ($reservations->num_rows > 0) {
        $meta['data'] = mysqli_fetch_all($reservations, MYSQLI_ASSOC);
    } else {
        $meta['data'] = []; 
    }
    if ($role == 0) {
        $sql = "SELECT 
                    r.id AS reservation_id,
                    r.reserved_date,
                    r.reserved_hours,
                    t.id AS table_id,
                    t.capacity AS table_capacity,
                    u.email AS customer_email,
                    res.NAME AS restaurant_name,
                    owner.email AS restaurant_owner_email
                FROM 
                    reserve r
                JOIN 
                    tables t ON r.table_id = t.id
                JOIN 
                    restaurants res ON t.resturant_id = res.id
                JOIN 
                    users u ON r.user_id = u.id
                JOIN 
                    users owner ON res.owner_id = owner.id".$where.$offset;
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $meta['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }elseif($role == 1){
        $owner_Id = $_SESSION['id'];
        $sql = "SELECT 
                    r.id AS reservation_id,
                    r.reserved_date,
                    r.reserved_hours,
                    t.id AS table_id,
                    t.capacity AS table_capacity,
                    u.email AS customer_email,
                    res.NAME AS restaurant_name
                FROM 
                    reserve r
                JOIN 
                    tables t ON r.table_id = t.id
                JOIN 
                    restaurants res ON t.resturant_id = res.id
                JOIN 
                    users u ON r.user_id = u.id
                WHERE 
                    res.owner_id = $owner_Id".$where.$offset;        
                    $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $meta['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
    echo json_encode($meta);
}

$conn->close();
?>

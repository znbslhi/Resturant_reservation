<?php
require './models/Reservation.php';

$reserve = new Reservation($msqlserver, $msqluser, $msqlpass, $msqldb);
$data = json_decode(file_get_contents('php://input'), true);
if (is_null($data)) {
    echo json_encode([
        'status' => 400,
        'error' => 'Invalid JSON input.'
    ]);
    exit;
}
$restaurant_id = $data['restaurant_id'] ?? null;
$table_index = intval($data['table_index'])-1 ?? 0;
$date = $data['date'] ?? null;
$requested_times = $data['requestedTimes'] ?? null;
$requested_capacity = $data['requestedCapacity'] ?? null; 
$user_id = $data['user_id'] ?? null;

// Validate required fields
if (is_null($restaurant_id) || is_null($table_index) || is_null($date) || is_null($requested_times) || is_null($requested_capacity) || is_null($user_id)) {
    echo json_encode([
        'status' => 400,
        'error' => 'Missing required fields.'
    ]);
    exit;
}

// Getting the table ID in the database from the index in the frontend
$sql = "SELECT id FROM `tables` WHERE resturant_id = $restaurant_id ORDER BY id LIMIT 1 OFFSET $table_index";
$result = $reserve->getConnection()->query($sql);
if ($result->num_rows > 0) {
    $table = $result->fetch_assoc(); 
    if ($reserve->isTableAvailable($table['id'], $date, $requested_times, $requested_capacity)) {
        $reserve->reserveTable($table['id'], $user_id, $date, $requested_times, $requested_capacity);
        $reserve_id = $reserve->getConnection()->insert_id;
        echo json_encode([
            'status' => 200,
            'message' => 'Reservation successful!',
            'order_id' => $reserve_id
        ]);
    } else {
        echo json_encode([
            'status' => 400,
            'message' => 'Table not available for the requested time slot or capacity.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 400,
        'message' => 'No Table Found'
    ]);
}
?>
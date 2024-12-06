<?php
require './models/Restaurants.php';
$user = null;
$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
}
$where = '';
$offset = '';
$perpage = 2;
$page = 1;
$meta = [];
if ($user != null ) {
    $sql = "SELECT id FROM `reserve` WHERE reserve.user_id=$user";
    $result = $conn->query($sql);
    $sql = "SELECT reserve.id, reserve.user_id,reserve.table_id, reserve.reserved_hours SUM(products.price * order_product.amount) as total, SUM(order_product.amount) as productCount
    FROM orders
    LEFT JOIN status ON status.id = orders.status_id
    LEFT JOIN order_product ON orders.id = order_product.order_id
    LEFT JOIN products ON products.id = order_product.product_id
    WHERE orders.id=$orderID GROUP BY id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        if ($order['user_id'] == $user) {
            $meta['data'] = $order;
            $sql = "SELECT products.*, orders.amount as amount
            FROM products
            RIGHT JOIN (SELECT amount, product_id
                FROM order_product WHERE order_id=$orderID) AS orders ON products.id = orders.product_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $meta['data']['products'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
            $meta['status'] = 200;
            echo json_encode($meta);
        }else {
            echo json_encode(['status' => 403]);
        }
    } else {
        echo json_encode(['status' => 404]);
    }
}
?>
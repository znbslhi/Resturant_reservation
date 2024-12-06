<?php
require './models/Restaurant.php';
$database = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
$restaurant = $database->getrestaurant($restaurantID);
echo json_encode($restaurant);
?>
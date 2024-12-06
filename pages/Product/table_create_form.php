<?php
require './models/Restaurant.php'; 

$restaurantModel = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
if($_SESSION['role']==1){
    $owner_id = $_SESSION['id'];
    $restaurants=$restaurantModel->getRestaurantsByOwner($owner_id);

}elseif($_SESSION['role']==0){
    $restaurants = $restaurantModel->restaurantsList();
}

$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $features = $conn->query( "SELECT * FROM features");


?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Create Form</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v20.0.0/dist/font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/styles/dashboard.css">
</head>

<body>
<div class="dashboard-container">
    <?php
    require "./pages/sidebar.php"?>
    <div class="container">
        <section id="top-container">
        <h1>افزودن میز</h1>
        <form action="http://localhost/tables/create" method="post">
            <div>
            <label for="restaurant">انتخاب رستوران:</label>
            <select name="restaurant_id" id="restaurant" required>
                <?php foreach ($restaurants as $restaurant): ?>
                    <option value="<?php echo $restaurant['id']; ?>">
                        <?php echo $restaurant['NAME']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            </div>


            <label for="capacity">ظرفیت:</label>
            <input type="number" id="capacity" name="capacity" min="0" required><br>

            <label for="start_time">زمان شروع فعالیت:</label>
            <input type="time" id="start_time" name="start_time" required><br>

            <label for="end_time">زمان پایان فعالیت:</label>
            <input type="time" id="end_time" name="end_time" required><br>

            <label for="status">وضعیت:</label>
            <select id="status" name="status" required>
                <option value="Available">فعال</option>
                <option value="Unavailable">غیرفعال</option>
            </select><br>
            <label>افزودن ویژگی های میز:</label><br>
            <?php foreach ($features as $feature): ?>
                <input type="checkbox" id="feature_<?php echo $feature['id']; ?>" name="features[]" value="<?php echo $feature['id']; ?>">
                <label for="feature_<?php echo $feature['id']; ?>"><?php echo $feature['title']; ?></label><br>
            <?php endforeach; ?>
            <input type="submit" value="افزودن">
        </form>


        </section>
    </div>
</div>


</body>

</html>
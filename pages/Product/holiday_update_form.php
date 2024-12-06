<?php
require './models/Holiday.php';
require './models/Restaurant.php'; 

$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$holidayModel = new Holidays($msqlserver, $msqluser, $msqlpass, $msqldb);
$holiday = $holidayModel->getHoliday($_GET['id']);

$restaurantModel = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
if($_SESSION['role']==1){
    $restaurants = $restaurantModel->getRestaurantsByOwner($_SESSION['id']);
}
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Restaurant</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v20.0.0/dist/font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
</head>
<body>
<div class="dashboard-container">
    <?php
    require "./pages/sidebar.php"?>
    <div class="container">
        <section id="top-container" class="content">
            <h1>ویرایش تعطیلات</h1>
            <form action="http://localhost/holidays/<?php echo $holiday['id']; ?>/update" method="POST">
                <input type="hidden" name="id" value="<?php echo $holiday['id']; ?>">
                <section>
                    <label for="restaurant_id">رستوران:</label>
                    <select id="restaurant_id" name="restaurant_id" required>
                        <option value="">انتخاب کنید</option>
                        <?php foreach ($restaurants as $restaurant): ?>
                            <option value="<?php echo $restaurant['id']; ?>"><?php echo $restaurant['NAME']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </section>
                <section>
                    <label for="date">تاریخ تعطیلات:</label>
                    <input type="date" id="date" name="date" value="<?php echo $holiday['DATE'];?>" required>
                </section>
                <section id="btn-submit">
                    <button type="submit">ویرایش</button>
                </section>
                <div class="link">
                <a href="/dashboard">بازگشت </a>
                </div>
            </form>

        </section>
    </div>
</div>
    
</body>
</html>


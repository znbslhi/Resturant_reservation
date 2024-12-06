<?php
require './models/Restaurant.php'; 
$restaurantModel = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
$restaurants = $restaurantModel->getRestaurantsByOwner($_SESSION['id']);      
?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>افزودن تعطیلات</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v20.0.0/dist/font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/styles/dashboard.css">
</head>

<body>
<div class="dashboard-container">
    <?php require "./pages/sidebar.php"; ?>
    <div class="container">
        <section id="top-container">
            <h1>افزودن تعطیلات</h1>
            <form action="http://localhost/holidays/create" method="post" class="form content">
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
                    <input type="date" id="date" name="date" required>
                </section>

                <section id="btn-submit">
                    <input type="submit" value="افزودن" name="Submit">
                </section>
                <div class="link">
                    <a href="/dashboard">بازگشت</a>
                </div>
            </form>
        </section>
    </div>
</div>
</body>
</html>

<?php
require './models/Restaurant.php';
$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$restaurant = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
$restaurant = $restaurant->getrestaurant($_GET['id']);
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
            <h1>ویرایش رستوران</h1>
            <form action="http://localhost/restaurants/<?php echo $restaurant['id']; ?>/update" method="POST">
                <input type="hidden" name="id" value="<?php echo $restaurant['id']; ?>">
                <label for="name">نام رستوران:</label>
                <input type="text" name="name" value="<?php echo $restaurant['NAME']; ?>" required><br>

                <label for="location">مکان رستوران:</label>
                <input type="text" name="location" value="<?php echo $restaurant['Location']; ?>" required><br>

                <label for="description">توضیحات رستوران:</label>
                <textarea name="description" required><?php echo $restaurant['Description']; ?></textarea><br>

                <label for="start_time">زمان شروع فعالیت :</label>
                <input type="time" name="start_time" value="<?php echo $restaurant['start_time']; ?>" required><br>

                <label for="end_time">زمان پایان فعالیت :</label>
                <input type="time" name="end_time" value="<?php echo $restaurant['end_time']; ?>" required><br>

                <label for="status">وضعیت فعالیت:</label>
                <select name="status" required>
                    <option value="1" <?php echo $restaurant['STATUS'] == 1 ? 'selected' : ''; ?>>باز</option>
                    <option value="0" <?php echo $restaurant['STATUS'] == 0 ? 'selected' : ''; ?>>بسته</option>
                </select><br>
                <button type="submit">ویرایش</button>
                <div class="link">
                <a href="/dashboard">بازگشت </a>
                </div>
            </form>

        </section>
    </div>
</div>
    
</body>
</html>


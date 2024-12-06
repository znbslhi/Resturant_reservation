<?php
require './models/Table.php';
$conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$Table = new Tables($msqlserver, $msqluser, $msqlpass, $msqldb);
$Table = $Table->getTable($_GET['id']);

$features = $conn->query( "SELECT * FROM features");


?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Update Form</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v20.0.0/dist/font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
</head>

<body>
<div class="dashboard-container">
    <?php
    require "./pages/sidebar.php"?>
    <div class="container">
        <section id="top-container">
        <h1>ویرایش میز</h1>
        <form action="http://localhost/tables/<?php echo $Table['id']; ?>/update" method="post">
            <input type="hidden" name="id" value="<?php echo $Table['id']; ?>">
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
            <label> ویژگی های فعال میز:</label><br>
            <?php foreach ($features as $feature): ?>
                <input type="checkbox" id="feature_<?php echo $feature['id']; ?>" name="features[]" value="<?php echo $feature['id']; ?>">
                <label for="feature_<?php echo $feature['id']; ?>"><?php echo $feature['title']; ?></label><br>
            <?php endforeach; ?>
            <input type="submit" value="ویرایش">
        </form>


        </section>
    </div>
</div>


</body>

</html>
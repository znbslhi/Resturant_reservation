<?php
    require './models/User.php';
    $conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $database = new User($msqlserver, $msqluser, $msqlpass, $msqldb);
    $user = $database->getAllUsers("","");
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/dashboard.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v20.0.0/dist/font-face.css" rel="stylesheet">
    <title>افزودن کاربر</title>
</head>
<body>
<div class="dashboard-container">
<?php
require "./pages/sidebar.php"?>
    <div class="container">
        <div class="top-container content" >
            <h2 class="form-title">افزودن کاربر</h2>
            <form class="form" action="http://localhost/users/create?>" method="POST">
                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" placeholder="ایمیل" required>
                <label for="password">رمز:</label>
                <input type="password" id="password" name="password" placeholder="رمز عبور" required>
                <label for="user_type">نوع کاربر:</label>
                <select id="user_type"name="user_type">
                    <option value="1" >رستوراندار</option>
                    <option value="2" >مشتری</option>
                </select>
            <button type="submit" class="submit-btn" >افزودن</button>
            </form>
            <div class="link">
                <a href="/dashboard/users">بازگشت </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
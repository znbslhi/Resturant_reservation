<?php
require './models/User.php';
$database = new User($msqlserver, $msqluser, $msqlpass, $msqldb);
$user = $database->getUserById($_GET['id']);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/dashboard.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v20.0.0/dist/font-face.css" rel="stylesheet">
    <title>ویرایش کاربر</title>
</head>
<body>
<div class="dashboard-container">
    <?php
    require "./pages/sidebar.php"?>
    <div class="container">
        <div class="top-container content">
            <h1 class="form-title">ویرایش کاربر</h1>
            <form id="updateForm" action="http://localhost/users/<?php echo $user['id']; ?>/update" method="POST">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <label for="email">ایمیل:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                
                <label for="user_type">نوع کاربر:</label>
                <select name="user_type">
                    <option value="1" <?php echo ($user['user_type'] == 1) ? 'selected' : ''; ?>>رستوراندار</option>
                    <option value="2" <?php echo ($user['user_type'] == 2) ? 'selected' : ''; ?>>مشتری</option>
                </select>
                <input type="submit" value="ویرایش">
            </form>
            <div class="link">
                <a href="/dashboard/users">بازگشت </a>
            </div>
        </div>
    </div>
</div>   
</body>
</html>
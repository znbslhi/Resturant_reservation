<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v20.0.0/dist/font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
</head>
<body>

<div class="dashboard-container">
    <?php
    require "./pages/sidebar.php"?>
        <div class="container">
            <div class="top-container">
                <div id="users" class="content">
                    <h2>مدیریت کاربران</h2>
                    <button class="btn-add"><a href="http://localhost/user_create_form">افزودن کاربر</a></button>
                    <table id="user-table">
                        <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>ایمیل</th>
                                <th>نوع کاربر</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body">
                        </tbody>
                    </table>
                    <div id="pagination1">
                        <button id="prev-page" disabled>قبلی</button>
                        <span id="page-info">صفحه 1 از 3</span>
                        <button id="next-page">بعدی</button>
                    </div>  
                </div>
            </div>
        </div>
</div>

<script src="../assets/scripts/admin_users.js"></script>
</body>
</html>

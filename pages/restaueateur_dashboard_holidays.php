<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>restaueateur Dashboard</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v20.0.0/dist/font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
</head>
<body>

<div class="dashboard-container">
<?php
require "./pages/sidebar.php"?>
    <div class="container">
        <div class="top-container">
            <div id="reservations" class="content">
                <h2>مدیریت تعطیلات</h2>
                <div class="top-options">
                    <button class="btn-add"><a href="http://localhost/holiday_create_form">افزودن تعطیلات</a></button>
                    <div id="search-form">
                        <input type="text" id="search-query" placeholder="جستجوی تاریخ">
                        <button type="button" id="search-btn">جستجو</button>
                    </div>
                </div>
                <table id="reservations-table">
                    <thead>
                        <tr>
                            <th>شناسه تعطیلات</th>
                            <th>تاریخ</th>
                            <th>نام رستوران</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="reservations-table-body">
                    </tbody>
                </table>
                <div id="pagination">
                    <button id="prev-page" disabled>قبلی</button>
                    <span id="page-info">صفحه 1 از 3</span>
                    <button id="next-page">بعدی</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/scripts/restaurateur_holidays.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>restaurateur Dashboard</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v20.0.0/dist/font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
</head>
<body>

<div class="dashboard-container">
<?php
require "./pages/sidebar.php"?>
    <div class="container">
        <div class="top-container">
            <div id="restaurants" class="content">
                <h2>مدیریت رستوران‌ها</h2>
                <div class="top-options">
                    <button class="btn-add"><a href="http://localhost/restaurant_create_form">افزودن رستوران</a></button>
                    <div id="search-form">
                        <input type="text" id="search-query" placeholder="نام رستوران">
                        <button type="button" id="search-btn">جستجو</button>
                    </div>
                </div>


                <table id="restaurants-table">
                    <thead>
                        <tr>
                            <th>شناسه رستوران</th>
                            <th>نام رستوران</th>
                            <th>جزئیات</th>
                            <th>تعداد رزروها</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="restaurants-table-body">
                        <tr>

                        </tr>
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
<div id="restaurant-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>جزئیات رستوران</h2>
        <div id="modal-body">
        </div>
    </div>
</div>
<script src="../assets/scripts/restaurateur_restaurants.js"></script>
</body>
</html>

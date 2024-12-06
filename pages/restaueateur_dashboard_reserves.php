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
                <h2>گزارش‌های رزرو</h2>
                <table id="reservations-table">
                    <thead>
                        <tr>
                            <th>شناسه رزرو</th>
                            <th>تاریخ رزرو</th>
                            <th>ساعت‌های رزرو</th>
                            <th>شناسه میز</th>
                            <th>ظرفیت میز</th>
                            <th>ایمیل مشتری</th>
                            <th>نام رستوران</th>
                        </tr>
                    </thead>
                    <tbody id="reservations-table-body">
                    </tbody>
                </table>
                <div id="pagination">
                    <button id="prev-page3" disabled>قبلی</button>
                    <span id="page-info3">صفحه 1 از 3</span>
                    <button id="next-page3">بعدی</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/scripts/restaurateur_reserves.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
</head>
<body>
<div class="dashboard-container">
    <div class="sidebar">
        <div class="logo">Panel</div>
        <div class="link-container">
            <div class="nav-links">
                <a href="#users" class="nav-link" onclick="showSection('users')">مدیریت کاربران</a>
                <a href="#restaurants" class="nav-link" onclick="showSection('restaurants')">مدیریت رستوران‌ها</a>
               <!-- <a href="#holidays" class="nav-link" onclick="showSection('holidays')">مدیریت تعطیلات</a>-->
                <a href="#reservations" class="nav-link" onclick="showSection('reservations')">گزارش‌های رزرو</a>
                <!--<a href="#settings" class="nav-link" onclick="showSection('settings')">تنظیمات</a>-->
            </div>
        </div>
    </div>
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
            <div id="restaurants" class="content" style="display: none;">
                <h2>مدیریت رستوران‌ها</h2>
                <button class="btn-add"><a href="http://localhost/restaurant_create_form">افزودن رستوران</a></button>
                <table id="restaurants-table">
                    <thead>
                        <tr>
                            <th>شناسه رستوران</th>
                            <th>شناسه رستوراندار</th>
                            <th>ایمیل رستوراندار</th>
                            <th>جزئیات</th>
                            <th>تعداد رزروها</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="restaurants-table-body">
                        <tr>
                            <td>1</td>
                            <td>owner1@example.com</td>
                            <td><button class="view-details" data-id="${restaurant.id}">مشاهده جزئیات</button></td>
                            <td>5</td>
                            <td>عملیات</td>
                        </tr>
                    </tbody>
                </table>
                <div id="pagination2" style="display: none;">
                    <button id="prev-page2" disabled>قبلی</button>
                    <span id="page-info2">صفحه 1 از 3</span>
                    <button id="next-page2">بعدی</button>
                </div>

            </div>
            <!--<div id="holidays" class="content" style="display: none;">
                <h2>مدیریت تعطیلات</h2>
                <button class="btn-add">افزودن تعطیلات</button>
                <p>محتوای مدیریت تعطیلات.</p>
            </div>-->
            <div id="reservations" class="content" style="display: none;">
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
                            <th>ایمیل صاحب رستوران</th>
                        </tr>
                    </thead>
                    <tbody id="reservations-table-body">
                    </tbody>
                </table>
                <div id="pagination3">
                    <button id="prev-page3" disabled>قبلی</button>
                    <span id="page-info3">صفحه 1 از 3</span>
                    <button id="next-page3">بعدی</button>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/scripts/admin-dashboard.js"></script>
</body>
</html>

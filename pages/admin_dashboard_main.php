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

</div>

<div id="user-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div id="user-modal-body">
            <!-- فرم به‌روزرسانی کاربر در اینجا بارگذاری خواهد شد -->
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!--<script src="../assets/scripts/admin-dashboard.js"></script>-->
</body>
</html>

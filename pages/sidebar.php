<?php if($_SESSION['role']==0){?>
    <div class="sidebar">
        <section class="logo">
            <a href="/">
                صفحه اصلی
            </a>
        </section>
    <div class="link-container">
        <div class="nav-links">
            <a href="/dashboard/users" class="nav-link" id="user_manage">مدیریت کاربران</a>
            <a href="/dashboard/restaurants" class="nav-link" id="restaurants_manage">مدیریت رستوران‌ها</a>
            <a href="/dashboard/tables" class="nav-link" id="tables_manage">مدیریت میزها</a>
            <!-- <a href="#holidays" class="nav-link" onclick="showSection('holidays')">مدیریت تعطیلات</a>-->
            <a href="/dashboard/reserves" class="nav-link" id="reserves_manage">گزارش رزروها</a>
            <!--<a href="#settings" class="nav-link" onclick="showSection('settings')">تنظیمات</a>-->
        </div>
    </div>
</div>
<?php }elseif($_SESSION['role']==1){?>
    <section class="sidebar">
        <section class="logo">
            <a href="/">
                صفحه اصلی
            </a>
        </section>
        <section class="link-container">
            <a href="/dashboard/restaurants" id="restaurants">رستوران ها</a>
            <a href="/dashboard/tables" id="tables">میزها</a>
            <a href="/dashboard/reserves" id="reserves">رزروها</a>
            <a href="/dashboard/holidays" id="holidays">تعطیلات</a>
        </section>
    </section>
    
<?php }?>

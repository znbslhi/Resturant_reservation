<?php
require './models/Restaurant.php'; 
require './models/User.php'; 

$userModel = new User($msqlserver, $msqluser, $msqlpass, $msqldb);
$owners = $userModel->getOwners();
$restaurantModel = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>افزودن رستوران</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v20.0.0/dist/font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/styles/dashboard.css">
</head>

<body>
<div class="dashboard-container">
    <?php
    require "./pages/sidebar.php"?>
    <div class="container">
        <section id="top-container">
            <h1>افزودن رستوران</h1>
            <form action="http://localhost/restaurants/create" method="post" enctype="multipart/form-data" class="form  content">
                <section>
                    <label for="name">نام رستوران:</label>
                    <input type="text" id="name" name="name" value="NAME">
                </section>
                <?php if($_SESSION['role']==0) {?>
                <section>
                    <label for="owner_id">شناسه رستوراندار:</label>
                    <select id="owner_id" name="owner_id">
                        <?php foreach ($owners as $owner): ?>
                            <option value="<?php echo $owner['id']; ?>"><?php echo $owner['email']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </section>
                <?php }?>
                <section>
                    <label for="Location">مکان رستوران:</label>
                    <input type="text" id="Location" name="Location" value="Location">
                </section>
                <section>
                    <label for="Description">توضیحات رستوران:</label>
                    <input type="text" id="Description" name="Description" value="">
                </section>
                <section>
                    <label for="start_time">زمان شروع فعالیت رستوران:</label>
                    <input type="time" id="start_time" name="start_time" value="10:00:00">
                </section>
                <section>
                    <label for="end_time">زمان پایان فعالیت رستوران:</label>
                    <input type="time" id="end_time" name="end_time" value="23:00:00">
                </section>
                <label for="status">وضعیت فعالیت:</label>
                <select name="status" id="status" required>
                    <option value="1" >باز</option>
                    <option value="0" >بسته</option>
                </select><br>
                <section id="btn-submit">
                    <input type="submit" value="افزودن" name="Submit">
                </section>
                <div class="link">
                <a href="/dashboard">بازگشت </a>
                </div>
            </form>

        </section>
    </div>
</div>


</body>

</html>
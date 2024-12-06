<!DOCTYPE html>
<html lang="en">
    <?php
    require './models/Restaurant.php';
    $database = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
    $restaurants = $database->restaurantsList();
    

    foreach ($restaurants as $index => $restaurant) {
        $totalCapacity = 0;
        if (isset($restaurant['tables'])) {
            foreach ($restaurant['tables'] as $table) {
                $totalCapacity += $table['capacity'];
            }
        }
        else{
            $totalCapacity+=0;
        }
        $restaurants[$index]['Capacity'] = $totalCapacity;

    }

    $title = 'Restaurant Reservation';
    require './pages/head.php';
    ?>
    <link rel="stylesheet" href="./assets/styles/style.css">
    <body>
        <section class="container">
            <?php require './pages/header.php'; ?>
            <header class="header">
                <h1 class="title">Reserve Your Table</h1>
                <p class="desc">Find the best restaurants and book your table now!</p>
            </header>

            <main class="main">
                <?php foreach ($restaurants as $restaurant) { ?>
                <section class="card-container">
                    <div class="image-container">
                        <img src="./assets/images/01.jpg" alt="Restaurant 1" class="image">
                    </div>
                    <div class="title-box">
                        <h2 class="card-title"><a href="/restaurants/<?php echo $restaurant['id']; ?>"><?php echo $restaurant['NAME']; ?></a></h2>
                    </div>
                    <section class="location-box">
                        <i class="fi fi-rs-marker"></i>
                        <p class="location"><?php echo $restaurant['Location']; ?></p>
                    </section>
                    
                    <section class="restaurant-details">
                        <ul>
                            <li>Capacity: <?php echo $restaurant['Capacity']; ?> people</li>
                            <li>Timings: <?php echo $restaurant['start_time'].' - '.$restaurant['end_time']; ?></li>
                        </ul>
                    </section>
                    <div class="btn-box">
                        <button class="btn-reserve">
                            <i class="fi fi-rr-calendar"></i>
                            <p><a href="/restaurants/<?php echo $restaurant['id']; ?>">View Details</a></p>
                        </button>
                    </div>
                </section>
                <?php } ?>
            </main>
            <?php require './pages/footer.php'; ?>
        </section> 
        <script src="../assets/scripts/app.js"></script>
    </body>
</html>

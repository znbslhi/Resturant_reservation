<!DOCTYPE html>
<html lang="en">
<?php
require './models/Restaurant.php';
$database = new Restaurants($msqlserver, $msqluser, $msqlpass, $msqldb);
$restaurant = $database->getRestaurant($restaurantID);
/*$features= $database->getTableFeatures($restaurant['tables']['1']);*/
$totalCapacity = 0;
if (isset($restaurant['tables'])) {
    foreach ($restaurant['tables'] as $table) {
        $totalCapacity += isset($table['Capacity']) ? $table['Capacity'] : 0;;
    }
}
$restaurant['Capacity'] = $totalCapacity;
$title='Restaurant Details';
require './pages/head.php'
?>
<link rel="stylesheet" href="./assets/styles/details.css">

<body>
<section class="container">
    <?php
    require './pages/header.php';
    ?>


    <section class="details-container">
        <!-- Restaurant Information Section -->
        <section class="about-container">
            <section class="image-container">
                <div class="main-image">
                    <img src="./assets/images/01.jpg" alt="Restaurant Image" class="image">
                </div>
                <div class="album">
                    <img class="album-item selected" src="../assets/images/02.jpg" alt="Image 1">
                    <img class="album-item" src="./assets/images/03.jpg" alt="Image 2">
                    <img class="album-item" src="./assets/images/04.jpg" alt="Image 3">
                </div>
            </section>
            <section class="about">
                <div class="about-container-desc">
                    <h2 class="about-title"><?php echo $restaurant['NAME'];?></h2>
                    <p class="about-desc"><?php echo $restaurant['Description'];?></p>    
                </div>
                <section class="details">
                    <h2 class="details-title">Restaurant Details</h2>
                    <section class="table">
                        <section class="th">
                        <div class="list-item">Location</div>
                        <div class="list-item">Capacity</div>
                        <div class="list-item">Services</div>
                        <div class="list-item">Timings</div>
                        </section>
                        <section class="td">
                            <div class="list-item"><?php echo $restaurant['Location'];?></div>
                            <div class="list-item"><?php echo $restaurant['Capacity'];?> people</div>
                            <div class="list-item"><?php echo $restaurant['table_features'];?></div>
                            <div class="list-item"><?php echo $restaurant['start_time'].'pm -'.$restaurant['end_time'].'am';?></div>
                        </section>
                    </section>
                </section>
            </section>
        </section>
        
        <!-- Available Tables Section -->
        <section class="main">
        <?php if (isset($restaurant['tables']) && is_array($restaurant['tables'])) { ?>
                <?php foreach ($restaurant['tables'] as $index => $table) { ?>
                <section class="card-container">
                    
                    <div class="title-box">
                        <h2 class="card-title"><a href="reservation.html?table=<?php echo $index + 1?>">Table <?php echo $index + 1?></a></h2>
                    </div>
                    
                    <section class="restaurant-details">
                        <ul>
                            <li>Capacity: <?php echo $table['capacity'];?> people</li>
                            <li>Services: <?php echo $table['features']; ?></li> 
                            <li>Services: <?php echo $table['status']; ?></li> 

                        </ul>
                    </section>
                    <div class="btn-box">
                    <?php if ($table['status']=='Available') { ?>
                        <button class="btn-reserve" 
                                data-table-id="<?php echo $index + 1; ?>"
                                data-capacity="<?php echo $table['capacity']; ?>"
                                data-features="<?php echo htmlspecialchars($table['features']); ?>"
                                data-timings="12pm - 12am"> 
                            <i class="fi fi-rr-calendar"></i>
                            <p>Reserve Now</p>
                        </button>
                    <?php } elseif($table['status']=='Unavailable') { ?>
                        <button class="btn-reserve" disabled="">
                            <i class="fi fi-rr-calendar"></i>
                            <p>Reserved</p>
                        </button>
                    <?php } ?>
                    </div>
                </section>
            <?php }?>
        <?php } ?>
        </section>
    </section>

    <?php
    require './pages/footer.php';
    ?>
        <div id="reservation-modal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <div class="table-info">
                    <h2></h2>
                    <p>Capacity: </p>
                    <p>Services: </p>
                    <p>Timings: </p>
                </div>
                <div class="reservation-form-container">
                    <div class="reservation-form">
                        <label for="reservation-date">Select Date:</label>
                        <input type="date" id="reservation-date">
                        
                        <label for="start-time">Start Time:</label>
                        <input type="time" id="start-time">
                        
                        <label for="duration">Duration (in hours):</label>
                        <input type="number" id="duration" min="1" placeholder="1">
                        <label for="Capacity-requested">Capacity:</label>
                        <input type="number" id="requested_capacity" min="1" placeholder="1">
                    </div>
                    <div class='confirm-reservation-conrainer'>
                        <button id="confirm-reservation">Confirm Reservation</button>
                    </div>
                </div>
            </div>
        </div>

    <script src="./assets/scripts/details.js"></script>
     <script>
        var tableData = <?php echo json_encode($restaurant['tables']); ?>;
        const restaurantID=<?php echo json_encode($restaurant['id']); ?>;
        const userID = <?php echo isset($_SESSION['id']) ? json_encode($_SESSION['id']) : 'null';?>    
        </script>
    </section>
</body>
</html>
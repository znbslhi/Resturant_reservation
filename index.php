<?php
$msqlserver = "localhost";
$msqluser = "znbslhi";
$msqlpass = "1234";
$msqldb = 'restaurant_reservation';
session_start();//Creates a session and receives the session if it exists
$request = $_SERVER['REQUEST_URI'];
$request = explode('?',$request)[0];
if(!isset($_SESSION['id']) && isset($_COOKIE['token'])) {
    $token = explode(':', $_COOKIE['token']);
    $conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT id, email, `password`, `user_type` FROM users WHERE email='" . $token[0] . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($token[1] == md5($row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['user_type'];
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/dashboard');
            exit;
        } else {
            session_destroy();
            setcookie("token", "", time() - 3600);
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login');
            exit;
        }
    } else {
        session_destroy();
        setcookie("token", "", time() - 3600);
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login');
        exit;
    }
    $conn->close();
}
if($request == '' ||$request == '/' ){
    require './pages/main.php';
}
elseif($request == '/login' || $request == '/login/') {
    if(isset($_SESSION['id'])) {
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/dashboard');
    }
    require './pages/login.php';

}
elseif($request == '/signup' || $request == '/signup/') {
    if(isset($_SESSION['id'])) {
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/dashboard');
    }
    require './pages/signup.php';

}
elseif($request == '/logout' || $request == '/logout/') {
    session_destroy();
    setcookie("token", "", time() - 3600);
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/login');
}elseif(preg_match('/^\/dashboard/', $request)) {
    if (!isset($_SESSION['role'])) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login');
        exit;
    } else {
        if ($_SESSION['role'] == '0') {//admin
            $request = str_replace('/dashboard', '', $request);

            if ($request == "" || $request == "/") {

                require './pages/admin_dashboard_main.php';

            } elseif ($request == "/users" || $request == "/users/") {

                require "./pages/admin_dashbaord_users.php";

            } elseif ($request == "/restaurants" || $request == "/restaurants/") {

                require "./pages/admin_dashboard_restaurant.php";

            } elseif ($request == "/reserves") {

                require "./pages/admin_dashboard_reserves.php";

            }elseif ($request == "/tables" || $request == "/tables/") {

                require "./pages/admin_dashboard_table.php";

            }elseif ($request == "/holidays" || $request == "/holidays/") {

                require "./pages/admin_dashboard_holidays.php";

            }
        } elseif ($_SESSION['role'] == '1') {//restaurateur
            $request = str_replace('/dashboard', '', $request);

            if ($request == "" || $request == "/") {

                require './pages/restaurateur_dashboard.php';

            } elseif ($request == "/restaurants" || $request == "/restaurants/") {

                require "./pages/restaueateur_dashboard_restaurant.php";

            } elseif ($request == "/reserves") {

                require "./pages/restaueateur_dashboard_reserves.php";

            }elseif ($request == "/tables" || $request == "/tables/") {

                require "./pages/restaueateur_dashboard_tables.php";

            }elseif ($request == "/holidays" || $request == "/holidays/") {

                require "./pages/restaueateur_dashboard_holidays.php";

            }
        } else {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
            exit;
        }
    }
}elseif (preg_match('/^\/restaurants(\/)/', $request)) {
    $request = str_replace('/restaurants', '', $request); // Remove '/restaurants'
    
    if (preg_match('/^\/[0-9]+$/', $request)) { // Only ID
        $part = explode('/', $request); // 0 => '', 1 => 'id'
        $restaurantID = $part[1];
        require './pages/details.php';
    } elseif (preg_match('/^\/[0-9]+\/update$/', $request)) {
        $part = explode('/', $request);
        $restaurantID = $part[1];
        require './pages/Product/restaurant_update.php';
    } elseif (preg_match('/^\/[0-9]+\/delete$/', $request)) {
        $part = explode('/', $request);
        $restaurantID = $part[1];
        require './pages/Product/restaurant_delete.php';
    } elseif (preg_match('/^\/create$/', $request)) {
        require './pages/Product/restaurant_create.php';
    }
}elseif (preg_match('/^\/tables(\/)/', $request)) {
    $request = str_replace('/tables', '', $request); // Remove '/tables'
    
    if (preg_match('/^\/[0-9]+\/update$/', $request)) {
        $part = explode('/', $request);
        $tableID = $part[1];
        require './pages/Product/table_update.php';
    } elseif (preg_match('/^\/[0-9]+\/delete$/', $request)) {
        $part = explode('/', $request);
        $tableID = $part[1];
        require './pages/Product/table_delete.php';
    } elseif (preg_match('/^\/create$/', $request)) {
        require './pages/Product/table_create.php';
    }
}elseif (preg_match('/^\/holidays(\/)/', $request)) {
    $request = str_replace('/holidays', '', $request); // Remove '/holidays'
    
    if (preg_match('/^\/[0-9]+\/update$/', $request)) {
        $part = explode('/', $request);
        $holidayID = $part[1];
        require './pages/Product/holiday_update.php';
    } elseif (preg_match('/^\/[0-9]+\/delete$/', $request)) {
        $part = explode('/', $request);
        $holidayID = $part[1];
        require './pages/Product/holiday_delete.php';
    } elseif (preg_match('/^\/create$/', $request)) {
        require './pages/Product/holiday_create.php';
    }
}elseif (preg_match('/^\/api\/restaurant\/[0-9]+$/', $request)) {
    $request = str_replace('/api/restaurant', '', $request);
    $part = explode('/', $request);
    $restaurantID= $part[1];
    require './api/restaurant.php';
}elseif (preg_match('/^\/api\/restaurants(\/)/', $request)) {

    $request = str_replace('/api/restaurants', '', $request);

    if (preg_match('/^\/[0-9]+/', $request)) {

        $part = explode('/', $request);

        $restaurantID = $part[1];

        if (preg_match('/^\/[0-9]+$/', $request)) {

            require './api/restaurants.php';

        }

    } elseif (preg_match('/^(\/)$/', $request)) {

        require './api/restaurants.php';

    }

}elseif (preg_match('/^\/api\/reserve\/[0-9]+$/', $request)) {
    $request = str_replace('/api/reserve', '', $request);
    $part = explode('/', $request);
    $reservationID = $part[1];
    require './api/reserve.php'; 
}elseif (preg_match('/^\/api\/reserves\/?$/', $request)) {
    require './api/reserves.php'; 
}elseif (preg_match('/^\/api\/reservation\/?$/', $request)) {
    if (!isset($_SESSION['id'])&&!isset($_COOKIE['token'])) {
        echo json_encode([
            'status' => 403,
            'error' => 'not login or unathorized'
        ]);
        exit;
    }
    require './api/reservation.php';
}elseif (preg_match('/^\/api\/load_users\/?$/', $request)) {
    require './api/load_users.php'; 
}elseif (preg_match('/^\/api\/load_tables\/?$/', $request)) {
    require './api/load_tables.php'; 
}elseif (preg_match('/^\/api\/holidays\/?$/', $request)) {
    require './api/holidays.php'; 
}elseif (preg_match('/^\/users(\/)/', $request)) {// User routes
    $request = str_replace('/users', '', $request); 
    if (preg_match('/^\/[0-9]+\/update$/', $request)) {
        $part = explode('/', $request);
        $userID = $part[1];
        require './pages/User/user_update.php';
    } elseif (preg_match('/^\/[0-9]+\/delete$/', $request)) {
        $part = explode('/', $request);
        $userID = $part[1];
        require './pages/User/user_delete.php';
    } elseif (preg_match('/^\/create$/', $request)) {
        require './pages/User/user_create.php';
    }
}elseif (preg_match('/^\/user_update_form\/?$/', $request)) {
    require './pages/User/user_update_form.php'; 
}elseif (preg_match('/^\/user_create_form\/?$/', $request)) {
    require './pages/User/user_create_form.php'; 
}elseif (preg_match('/^\/restaurant_create_form\/?$/', $request)) {
    require './pages/Product/restaurant_create_form.php'; 
}elseif (preg_match('/^\/restaurant_update_form\/?$/', $request)) {
    require './pages/Product/restaurant_update_form.php'; 
}elseif (preg_match('/^\/table_create_form\/?$/', $request)) {
    require './pages/Product/table_create_form.php'; 
}elseif (preg_match('/^\/table_update_form\/?$/', $request)) {
    require './pages/Product/table_update_form.php'; 
}elseif (preg_match('/^\/holiday_create_form\/?$/', $request)) {
    require './pages/Product/holiday_create_form.php'; 
}elseif (preg_match('/^\/holiday_update_form\/?$/', $request)) {
    require './pages/Product/holiday_update_form.php'; 
}elseif($request == '/post') {
    require './post.php';
} else {
    
    echo "404";
}
?>
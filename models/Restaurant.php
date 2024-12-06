<?php

class Restaurants
{
    private $Conn;
    public function __construct($msqlserver, $msqluser, $msqlpass, $msqldb)
    {
        $conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->Conn = $conn;
    }
    
    public function getRestaurant($id) {
        $sql = "SELECT * FROM restaurants WHERE id='$id'";
        $result = $this->Conn->query($sql);
        
        if ($result->num_rows > 0) {
            $restaurant = $result->fetch_assoc();
            $restaurant['tables'] = $this->getRestaurantTables($id);
            $restaurant['table_features'] = $this->getAllTableFeatures($id);
            return $restaurant;
        }
        return null; // اگر رستوران پیدا نشد
    }

    public function restaurantsList($where = '') {
        $sql = "SELECT * FROM restaurants ".$where;
        $result = $this->Conn->query($sql);

        if ($result->num_rows > 0) {
            $restaurants = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($restaurants as &$restaurant) {
                $restaurant['tables'] = $this->getRestaurantTables($restaurant['id']);
            }

            return $restaurants;
        }
        return [];
    }
    private function getRestaurantTables($restaurantId) {
        $sql = "SELECT * FROM tables WHERE resturant_id='$restaurantId'";
        $result = $this->Conn->query($sql);

        if ($result->num_rows > 0) {
            $tables = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($tables as &$table) {
                $table['features'] = $this->getTableFeatures($table['id']);
                
            }

            return $tables;
        }

        return [];
    }
    public function getRestaurantsByOwner($ownerId) {//ّFor create Table Form && holiday
        $sql = "SELECT id, NAME FROM restaurants WHERE owner_id='$ownerId'";
        $result = $this->Conn->query($sql);
    
        if ($result->num_rows > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }
    
    public function getTableFeatures($tableId) {
        $sql = "SELECT f.title FROM features f
                JOIN feature_table ft ON f.id = ft.feature_id
                WHERE ft.table_id = '$tableId'";
        $result = $this->Conn->query($sql);

        if ($result->num_rows > 0) {
            $features = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $featureTitles = array_column($features, 'title');
            return implode(', ', $featureTitles);
        }
        return 'No Services';
    }
    public function getAllTableFeatures($restaurantId) {
        $tables = $this->getRestaurantTables($restaurantId);
        $allFeatures = [];
    
        foreach ($tables as $table) {
            $features = $this->getTableFeatures($table['id']);
            if($features!='No Services'){
                $allFeatures[$table['id']] = $features;
            }
        }
        if (empty($allFeatures)) {
            return 'No Services';
        }
    
        return implode(', ', array_unique($allFeatures));
    }
    
    public function updateRestaurant($id, $name, $location,$description,$startTime,$endTime,$status) {

        $sql = "UPDATE restaurants
                SET 
                    NAME = '$name',
                    Location = '$location',
                    Description = '$description',
                    start_time = '$startTime',
                    end_time = '$endTime',
                    STATUS = '$status' 
                WHERE id = $id";
        return $this->Conn->query($sql);
    }

    public function deleteRestaurant($id) {
    // Delete reserves 
    $sql = "DELETE FROM reserve WHERE table_id IN (SELECT id FROM tables WHERE resturant_id='$id')";
    $this->Conn->query($sql);

    // Delete feature_table
    $sql = "DELETE FROM feature_table WHERE table_id IN (SELECT id FROM tables WHERE resturant_id='$id')";
    $this->Conn->query($sql);

    // Delete tables 
    $sql = "DELETE FROM tables WHERE resturant_id='$id'";
    $this->Conn->query($sql);

    // Delete holidays
    $sql = "DELETE FROM holidays WHERE resturant_id='$id'";
    $this->Conn->query($sql);

    $sql = "DELETE FROM restaurants WHERE id='$id'";
    return $this->Conn->query($sql);
    }
    public function addRestaurant ($owner_id,$name, $location,$description,$startTime,$endTime,$status) {
        $sql = "INSERT INTO `restaurants` (`owner_id`, `Name`, `Location`, `Description`, `start_time`, `end_time`, `STATUS`) VALUES ( '$owner_id', '$name', '$location', '$description', '$startTime', '$endTime', $status)";
        $result['result']=$this->Conn->query($sql);
        $result['id']=$this->Conn->insert_id;
        return $result;
    }
}

?>

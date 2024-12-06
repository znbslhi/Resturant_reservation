<?php

class Tables
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

    public function getTablesByRestaurant($restaurantId) {
        $sql = "SELECT * FROM tables WHERE resturant_id='$restaurantId'";
        $result = $this->Conn->query($sql);

        if ($result->num_rows > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }

    public function getTable($id) {
        $sql = "SELECT * FROM tables WHERE id='$id'";
        $result = $this->Conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function addTable($restaurantId, $capacity, $start_time, $end_time ,$status, $features) {
        $sql = "INSERT INTO `tables` (`resturant_id`, `capacity`, `start_time`, `end_time`, `status`) 
                VALUES ('$restaurantId', '$capacity', '$start_time', '$end_time', '$status')";
        if ($this->Conn->query($sql) === TRUE) {
            $tableId = $this->Conn->insert_id;
            // افزودن ویژگی‌های میز
            $this->addTableFeatures($tableId, $features);
            return ['result' => true, 'id' => $tableId];
        }
        return ['result' => false];
    }

    private function addTableFeatures($tableId, $features) {
        $success = true; 
        foreach ($features as $featureId) {
            if (is_numeric($featureId)) {
                $sql = "INSERT INTO `feature_table` (`feature_id`, `table_id`) VALUES ('$featureId', '$tableId')";
                if (!$this->Conn->query($sql)) {
                    $success = false; 
                }
            }
        }
    
        return $success; // بازگشت نتیجه نهایی
    }
    private function updateTableFeatures($tableId, $features) {
        $sql = "DELETE FROM `feature_table` WHERE `table_id` = $tableId";
        if ($this->Conn->query($sql)) {
            $result=$this->addTableFeatures($tableId, $features);
            if ($result) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function updateTable($id, $capacity, $start_time,$end_time,$status,$features) {
        $result = [];
        $sql = "UPDATE `tables` SET `capacity` = '$capacity', `start_time` = '$start_time', `end_time` = '$end_time', `status` = '$status' WHERE `tables`.`id` = $id";
        if ($this->Conn->query($sql)) {
            $result=$this->updateTableFeatures($id, $features);
            if ($result) {
                return true;
            }
            return false;
        }
        return false;  
    }

    public function deleteTable($id) {
        $sql = "DELETE FROM `reserve` WHERE `table_id` = '$id'";
        $this->Conn->query($sql);

        $sql = "DELETE FROM feature_table WHERE table_id='$id'";
        $this->Conn->query($sql);

        $sql = "DELETE FROM tables WHERE id='$id'";
        return $this->Conn->query($sql);
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
}

?>
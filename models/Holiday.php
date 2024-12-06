<?php

class Holidays
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

    public function addHoliday($restaurant_id, $date) {
        $sql = "INSERT INTO holidays (resturant_id, date) VALUES ('$restaurant_id', '$date')";
        $result['result']=$this->Conn->query($sql);
        $result['id']=$this->Conn->insert_id;
        return $result;
    }

    public function updateHoliday($id, $restaurant_id, $date) {
        $sql = "UPDATE holidays SET resturant_id = '$restaurant_id', date = '$date' WHERE id = $id";
        return $this->Conn->query($sql);
    }

    public function deleteHoliday($id) {
        $sql = "DELETE FROM holidays WHERE id = $id";
        return $this->Conn->query($sql);
    }

    public function getHolidays($restaurant_id) {
        $sql = "SELECT * FROM holidays WHERE resturant_id = '$restaurant_id'";
        $result = $this->Conn->query($sql);

        if ($result->num_rows > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }

    public function getHoliday($id) {
        $sql = "SELECT * FROM holidays WHERE id = '$id'";
        $result = $this->Conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null; // اگر تعطیلی پیدا نشد
    }
}
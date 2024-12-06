<?php
class Reservation {
    private $Conn;
    public function __construct($msqlserver, $msqluser, $msqlpass, $msqldb) {
        $conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->Conn = $conn;

    }
    public function getConnection() {
        return $this->Conn;
    }
    public function isTableAvailable($table_id, $date, $requested_times, $requested_capacity) {
        $sql = "SELECT start_time, end_time, capacity, status FROM tables WHERE id = $table_id";
        $result = $this->Conn->query($sql);
        if ($result->num_rows > 0) {
            $table = $result->fetch_assoc();
            $start_time_table = $table['start_time'];
            $end_time_table = $table['end_time'];
            $capacity_table = $table['capacity'];
            $status_table = $table['status'];

        
            if ($status_table !== 'Available') {
                return false; // Unavailable table requested
            }
            if ($requested_capacity > $capacity_table) {
                return false; // invalid capacity requested
            }       
            foreach ($requested_times as $time) {
                if ($time < $start_time_table && $time > $end_time_table) {
                    return false; // invalid time requested
                }
            }
        
            $sql = "SELECT reserved_hours FROM reserve WHERE table_id = $table_id AND DATE(reserved_date) = '$date'";
            $result = $this->Conn->query($sql);
            $reserved_hours = []; 
            while ($row = $result->fetch_assoc()) {
                $reserved_hours = json_decode($row['reserved_hours'], true)??[];                
                foreach ($reserved_hours as $reserved_time) { // checking conflicts with existing reservations
                    foreach ($requested_times as $requested_time) {
                        if (
                            ($requested_time >= $reserved_time && $requested_time < end($reserved_hours)) ||
                            (end($requested_times) > $reserved_time && $requested_time <= $reserved_time)
                        ) {
                            return false; // conflicts occurred
                        }
                    }
                }
                return true;//'conflicts not occurred'
            }
            return true;//no reservation in this date
        }
        return false; //Table not exist
    }

    public function reserveTable($table_id, $user_id, $date, $requested_times) {
        $reserved_hours_json = json_encode($requested_times);
        $sql = "INSERT INTO reserve (user_id, table_id, reserved_date, reserved_hours) 
                VALUES ($user_id, $table_id, '$date', '$reserved_hours_json')";
        if ($this->Conn->query($sql)) {
            //$this->markTableAsUnavailable($table_id); 
            return true;
        }
        return false;
    }
    public function markTableAsUnavailable($table_id) {
        $sql = "UPDATE tables SET status = 'Unavailable' WHERE id = $table_id";
        return $this->Conn->query($sql);
    }
    public function getTotalReservations($where = '') {
        $sql = "SELECT COUNT(*) AS total FROM reserve" . $where;
        $result = $this->Conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function getAllReservations($where = '', $offset = '') {
        $sql = "SELECT * FROM reserve" . $where . $offset;
        return $this->Conn->query($sql);
    }
   /* public function markTableAsAvailable($table_id) {
        $sql = "UPDATE tables SET status = 'Available' WHERE id = $table_id";
        return $this->Conn->query($sql);
    }*/
}
?>   

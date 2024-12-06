<?php
class User {
    private $Conn;
    public function __construct($msqlserver, $msqluser, $msqlpass, $msqldb)
    {
        $conn = new mysqli($msqlserver, $msqluser, $msqlpass, $msqldb);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->Conn = $conn;
    }
    public function getTotalUsers($where) {
        $sql = "SELECT COUNT(*) as total FROM users".$where; 
        $result = $this->Conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function getAllUsers($where,$offset) {
        $sql = "SELECT id, email, user_type FROM users".$where.$offset;
        return $this->Conn->query($sql);
    }
    public function getOwners() {//for create_restaurant_form
        $query = "SELECT id, email FROM users WHERE user_type = 1"; 
        $result = $this->Conn->query($query);
        $owners = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $owners[] = $row;
            }
        }
        return $owners;
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id='$id'";
        $result=$this->Conn->query($sql);
        return $result->fetch_assoc();
    }

    public function updateUser($id, $email, $user_type) {
                
        $sql = "UPDATE restaurants SET owner_id = NULL WHERE owner_id ='$id'";
        $this->Conn->query($sql);  
        $sql = "UPDATE users SET email='$email', user_type='$user_type' WHERE id='$id'";
        return $this->Conn->query($sql);
    }

    public function deleteUser($id) {
        // Delete the restaurant records of the 'reserve table' that is dependent on the 'tables table' for this user
        $sql = "DELETE FROM reserve WHERE table_id IN (SELECT id FROM tables WHERE resturant_id IN (SELECT id FROM restaurants WHERE owner_id = '$id'))";
        $this->Conn->query($sql);
    
        // Delete restaurants from the tables table for this user
        $sql = "DELETE FROM tables WHERE resturant_id IN (SELECT id FROM restaurants WHERE owner_id = '$id')";
        $this->Conn->query($sql);
    
        // Delete restaurants for this user
        $sql = "DELETE FROM restaurants WHERE owner_id = '$id'";
        $this->Conn->query($sql);
    
        $sql = "DELETE FROM users WHERE id='$id'";
        return $this->Conn->query($sql);
    }
    public function addUser($email, $password, $user_type) {
        $sql = "INSERT INTO users (email, PASSWORD, user_type) VALUES ('$email', '$password', '$user_type')";
        $result['result']=$this->Conn->query($sql);
        $result['id']=$this->Conn->insert_id;
        return $result;
    }
}
?>


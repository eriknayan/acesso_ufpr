<?php

class DBSingleton {

    public static $instance;

    // Don't allow instantiation of this class
    protected function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance() {
        if (self::$instance === null) {
            require_once('utilities.php');

            // Connect to database
            $dbhost = 'localhost';
            $dbuser = Keys::getDbUser();
            $dbpass = Keys::getDbPasswd();
            $dbname = 'arion';
            self::$instance = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

            // Checks if successfully connected to db
            if(self::$instance->connect_errno) {
                error_log("Failed to connect to db.");
                return null;
            }
        }

        return self::$instance;
    }
}

class REST {
    private $db;
    
    public function __construct() {
        $this->db = DBSingleton::getInstance();
    }
    
    
    public function getUser($cardId) {
        $cardId = $this->escape_string($cardId);
        
        $query = "SELECT cardId, name, email, grr, type, balance FROM Users WHERE cardId=" . $cardId . ";";
        if($result = $this->db->query($query)) {
            return $result->fetch_assoc();
        }
        return false;
    }   
    public function getRestaurant($restId = null) {
        
        if ($restId !== null) {
            $restId = $this->escape_string($restId);
            $query = "SELECT restId, restName, restAddr FROM Restaurants WHERE restId=" . $restId . ";";
        }
        else {
            $query = "SELECT restId, restName, restAddr FROM Restaurants;";            
        }
                
        if($result = $this->db->query($query)) {
            $out = array();
            while ($row = $result->fetch_assoc()) {
                array_push($out, $row);
            }
            return $out;
        }
        return false;
    }
    public function getTransaction($cardId = null, $startDate = null, $endDate = null) {
        if ($cardId !== null) $cardId = $this->escape_string($cardId);
        if ($startDate !== null) $startDate = $this->escape_string($startDate);
        if ($endDate !== null) $endDate = $this->escape_string($endDate);
        
        $query = "SELECT tranId, cardId, value, tranTime, restId FROM Transactions";
        if (empty($cardId) && empty($startDate) && empty($endDate)) {
            $query .= ';';
        }
        else {
            $query .= ' WHERE ';
            if ($cardId !== null && $startDate !== null && endDate !== null) {
                $query .= 'cardId=' . $cardId . ' AND DATE(tranTime) BETWEEN "' . $startDate . '" AND "' . $endDate . '" ORDER BY tranTime;';
            }
            else if ($cardId !== null) {
                $query .= 'cardId=' . $cardId . ' ORDER BY tranTime;';
            }
            else {
                $query .= 'DATE(tranTime) BETWEEN "' . $startDate . '" AND "' . $endDate . '" ORDER BY tranTime;';
            }
        }

        if($result = $this->db->query($query)) {
            $out = array();
            while ($row = $result->fetch_assoc()) {
                array_push($out, $row);
            }
            return $out;
        }
        return false;
        
    }
    public function getCurrentMealValue() {
        $now = date('H');
        
        if ($now < 11) {
            // Breakfast
            if ($result = $this->db->query('SELECT value FROM Meals WHERE name="Breakfast";')) {
                return $result->fetch_assoc()['value'];
            }         
        }
        else if ($now < 17) {
            // Lunch
            if ($result = $this->db->query('SELECT value FROM Meals WHERE name="Lunch";')) {
                return $result->fetch_assoc()['value'];
            }  
        }
        else {
            // Dinner
            if ($result = $this->db->query('SELECT value FROM Meals WHERE name="Dinner";')) {
                return $result->fetch_assoc()['value'];
            }  
        }
        return false;
    }
    
    
    public function insertUser($cardId, $name, $email, $password, $grr, $type) {
        $cardId = $this->escape_string($cardId);
        $name = $this->escape_string($name);
        $email = $this->escape_string($email);
        $password = $this->escape_string($password);
        $grr = $this->escape_string($grr);
        $type = $this->escape_string($type);
        $balance = 0;
        
        $password = password_hash($password, PASSWORD_BCRYPT);
        
        $query = 'INSERT INTO Users VALUES (' . $cardId . ', "' . $name . '", "' . $email . '", "' . $password . '", ' . $grr . ', ' . $type . ', "0.00", NOW());';
        return $this->db->query($query);
    }   
    public function insertRestaurant($restName, $restAddr) {
        $restName = $this->escape_string($restName);
        $restAddr = $this->escape_string($restAddr);
        
        $query = 'INSERT INTO Restaurants (restName, restAddr) VALUES ("' . $restName . '", "' . $restAddr . '");';
        return $this->db->query($query);
    }
    public function insertTransaction($cardId, $value, $restId) {
        $cardId = $this->escape_string($cardId);
        $value = $this->escape_string($value);
        $restId = $this->escape_string($restId);
        
        $query = 'SELECT balance FROM Users WHERE cardId=' . $cardId . ';';
        if ($result = $this->db->query($query)) {
            $balance = $result->fetch_assoc()['balance'];
        }
        else {
            return "erro";
        }
        
        $newBalance = $balance + $value;
        if ($newBalance < 0) {
            return "balance";
        }
        
        $query = 'INSERT INTO Transactions (cardId, value, tranTime, restId) VALUES (' . $cardId . ', ' . $value . ', NOW(), ' . $restId . ');';
        if (!$this->db->query($query)) return "id";
        
        // Updates user with new balance
        $query = 'UPDATE Users SET balance=' . $newBalance . ' WHERE cardId=' . $cardId . ';';
        if ($this->db->query($query)) {
            return $newBalance;
        }
        return "erro";
    }
    
    
    public function updateUser($cardId, $name = null, $email = null, $password = null, $grr = null, $type = null) {
        if ($name !== null) $updateArray['name'] = $this->escape_string($name);
        if ($email !== null) $updateArray['email'] = $this->escape_string($email);
        if ($password !== null) $updateArray['password'] = password_hash($this->escape_string($password), PASSWORD_BCRYPT);
        if ($grr !== null) $updateArray['grr'] = $this->escape_string($grr);
        if ($type !== null) $updateArray['type'] = $this->escape_string($type);
        
        $query = 'UPDATE Users SET ';
        foreach ($updateArray as $key => $value) {
            $query .= $key . '="' . $value . '", ';
        }
        // Eliminate last ', ' substring
        $query = substr($query, 0, -2);
        $query .= ' WHERE cardId=' . $this->escape_string($cardId) . ';';
        
        return $this->db->query($query);
    }
    public function updateRestaurant($restId, $restName = null, $restAddr = null) {
        if ($restName !== null) $updateArray['restName'] = $this->escape_string($restName);
        if ($restAddr !== null) $updateArray['restAddr'] = $this->escape_string($restAddr);
        
        $query = 'UPDATE Restaurants SET ';
        foreach ($updateArray as $key => $value) {
            $query .= $key . '="' . $value . '", ';
        }
        $query = substr($query, 0, -2);
        $query .= ' WHERE restId=' . $this->escape_string($restId) . ';';
        
        return $this->db->query($query);
    }
    public function updateTransaction($tranId, $cardId = null, $value = null, $tranTime = null, $restId = null) {
        if ($cardId !== null) $updateArray['cardId'] = $this->escape_string($cardId);
        if ($value !== null) $updateArray['value'] = $this->escape_string($value);
        if ($tranTime !== null) $updateArray['tranTime'] = $this->escape_string($tranTime);
        if ($restId !== null) $updateArray['restId'] = $this->escape_string($restId);
        
        $query = 'UPDATE Transactions SET ';
        foreach ($updateArray as $key => $arrValue) {
            $query .= $key . '="' . $arrValue . '", ';
        }
        $query = substr($query, 0, -2);
        $query .= ' WHERE tranId=' . $this->escape_string($tranId) . ';';
        
        return $this->db->query($query);
    }
    public function updateMealValue($name, $value) {
        $name = $this->escape_string($name);
        $value = $this->escape_string($value);
        
        return $this->db->query('UPDATE Meals SET value="' . $value . '" WHERE name=' . $name . ';');
    }
    
    
    public function deleteUser($cardId) {
        $cardId = $this->escape_string($cardId);
        
        $query = 'DELETE from Users WHERE cardId=' . $cardId . ';';
        return $this->db->query($query);
    }
    public function deleteRestaurant($restId) {
        $restId = $this->escape_string($restId);
        
        $query = 'DELETE from Restaurants WHERE restId=' . $restId . ';';
        return $this->db->query($query);
    }
    public function deleteTransaction($tranId) {
        $tranId = $this->escape_string($tranId);
        
        $query = 'DELETE from Transactions WHERE tranId=' . $tranId . ';';
        return $this->db->query($query);        
    }
    
    private function escape_string($string) {
        return $this->db->real_escape_string($string);
    }
}

?>
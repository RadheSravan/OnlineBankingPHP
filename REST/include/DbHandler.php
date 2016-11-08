<?php
class DbHandler
{
    
    private $conn;
    
    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        
        $db         = new DbConnect();
        $this->conn = $db->connect();
    }
    
    public function createUser($user_name, $password, $first_name, $last_name, $email)
    {
        
        require_once 'PassHash.php';
        
        $response = array();
        
        if (!$this->isUserExists($user_name, $email)) {
            
            $password_hash = PassHash::hash($password);
            $api_key       = $this->generateApiKey();
            
            $stmt = $this->conn->prepare("INSERT INTO customers(user_name, password, first_name, last_name, email, api_key) values(?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $user_name, $password_hash, $first_name, $last_name, $email, $api_key);
            
            $result = $stmt->execute();
            
            $stmt->close();
            
            if ($result) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
        
        return $response;
    }
    
    
    public function checkLogin($user_name, $password)
    {
        
        $stmt = $this->conn->prepare("SELECT password FROM customers WHERE user_name = ?");
        
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $stmt->bind_result($password_hash);
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            
            $stmt->fetch();
            $stmt->close();
            
            if (PassHash::check_password($password_hash, $password)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $stmt->close();
            return FALSE;
        }
    }
    
    public function updateLastLogin($customer_id)
    {
        date_default_timezone_set('Asia/Kolkata');
        $dateTime = new DateTime("NOW");
        $date     = $dateTime->format('Y-m-d H:i:s');
        
        $stmt = $this->conn->prepare("UPDATE customers set last_login = ? WHERE customer_id = ? ");
        
        $stmt->bind_param("si", $date, $customer_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        
        return $num_affected_rows > 0;
        
    }
    
    private function isUserExists($user_name, $email)
    {
        
        $stmt = $this->conn->prepare("SELECT customer_id from customers WHERE user_name = ?");
        
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        
        if ($num_rows > 0) {
            return true;
        } else {
            $stmt = $this->conn->prepare("SELECT customer_id from customers WHERE email = ?");
            $stmt->bind_param("s", $user_name);
            $stmt->execute();
            $stmt->store_result();
            $num_rows = $stmt->num_rows;
            $stmt->close();
            return $num_rows > 0;
        }
        return false;
    }
    
    
    public function getUserByUsername($user_name)
    {
        $stmt = $this->conn->prepare("SELECT customer_id, first_name, last_name, api_key, last_login FROM customers WHERE user_name = ?");
        
        $stmt->bind_param("s", $user_name);
        
        if ($stmt->execute()) {
            
            $stmt->bind_result($customer_id, $first_name, $last_name, $api_key, $last_login);
            $stmt->fetch();
            
            $user = array();
            
            $user["customer_id"] = $customer_id;
            $user["first_name"]  = $first_name;
            $user["last_name"]   = $last_name;
            $user["api_key"]     = $api_key;
            $user["last_login"]  = $last_login;
            
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }
    
    public function getAllAccounts($customer_id)
    {
        $stmt = $this->conn->prepare("SELECT account.* FROM accounts account, customers customer WHERE account.customer_id = customer.customer_id AND customer.customer_id = ?");
        
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $accounts = $stmt->get_result();
        $stmt->close();
        
        return $accounts;
    }
    
    public function createAnnouncement($announcement)
    {
        $response = array();
        
        $stmt = $this->conn->prepare("INSERT INTO announcements(announcement) values(?)");
        $stmt->bind_param("s", $announcement);
        
        $result = $stmt->execute();
        
        $stmt->close();
        
        if ($result) {
            return 0;
        } else {
            return 1;
        }
        
        
        return $response;
    }
    
    public function getAllAnnouncements()
    {
        
        $stmt = $this->conn->prepare("SELECT * FROM announcements");
        
        $stmt->execute();
        $announcements = $stmt->get_result();
        $stmt->close();
        
        return $announcements;
    }
    
    public function getAnnouncementById($announcement_id)
    {
        
        $stmt = $this->conn->prepare("SELECT * FROM announcements where announcement_id = ?");
        $stmt->bind_param("i", $announcement_id);
        $stmt->execute();
        $announcement = $stmt->get_result();
        $stmt->close();
        
        return $announcement;
    }
    
    public function updateAnnouncement($announcement_id, $announcement)
    {
        
        $stmt = $this->conn->prepare("UPDATE announcements set announcement = ? WHERE announcement_id = ? ");
        
        $stmt->bind_param("si", $announcement, $announcement_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        
        return $num_affected_rows > 0;
    }
    
    public function deleteAnnouncement($announcement_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM announcements WHERE announcement_id = ?");
        
        $stmt->bind_param("i", $announcement_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        
        return $num_affected_rows > 0;
    }
    
    public function getApiKeyById($customer_id)
    {
        
        $stmt = $this->conn->prepare("SELECT api_key FROM customers WHERE customer_id = ?");
        
        $stmt->bind_param("i", $customer_id);
        
        if ($stmt->execute()) {
            $stmt->bind_result($api_key);
            $stmt->close();
            return $api_key;
        } else {
            return NULL;
        }
    }
    
    public function getCustomerId($api_key)
    {
        
        $stmt = $this->conn->prepare("SELECT customer_id FROM customers WHERE api_key = ?");
        
        $stmt->bind_param("s", $api_key);
        
        if ($stmt->execute()) {
            $stmt->bind_result($customer_id);
            $stmt->fetch();
            $stmt->close();
            return $customer_id;
        } else {
            return NULL;
        }
    }
    
    
    public function isValidApiKey($api_key)
    {
        
        $stmt = $this->conn->prepare("SELECT customer_id from customers WHERE api_key = ?");
        
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        
        return $num_rows > 0;
    }
    
    private function generateApiKey()
    {
        return md5(uniqid(rand(), true));
    }
    
}

?>

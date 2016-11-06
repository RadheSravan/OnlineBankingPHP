<?php

/**
 *
 * @author Radhe Sravan
 */
class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }


    /**
     * Creating new customer
     * @param String $user_name 
     * @param String $password
     * @param String $first_name
     * @param String $last_name
     * @param String $email

     */
    public function createUser($user_name,$password,$first_name,$last_name,$email) {
        require_once 'PassHash.php';
        $response = array();

        // First check if user already existed in db
        if (!$this->isUserExists($user_name, $email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // Generating API key
            $api_key = $this->generateApiKey();

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO customers(user_name, password, first_name, last_name, email, api_key) values(?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $user_name, $password_hash, $first_name, $last_name, $email,     $api_key);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same username or email already exists in the db
            return USER_ALREADY_EXISTS;
        }

        return $response;
    }

    /**
     * Processing login request
     * @param String $user_name
     * @param String $password
     * @return boolean Customer's login status success/fail
     */
    public function checkLogin($user_name, $password) {
        // fetching user by username
        $stmt = $this->conn->prepare("SELECT password FROM customers WHERE user_name = ?");

        $stmt->bind_param("s", $user_name);

        $stmt->execute();

        $stmt->bind_result($password_hash);

        $stmt->store_result();

        if ($stmt->num_rows > 0) {

            $stmt->fetch();

            $stmt->close();

            if (PassHash::check_password($password_hash, $password)) {
                // User password is correct
                return TRUE;
            } else {
                // user password is incorrect
                return FALSE;
            }
        } else {
            $stmt->close();

            // user doesn't exist
            return FALSE;
        }
    }

    /**
     * Checking for duplicate customer by username and email address
     * @param String $user_name
     * @param String $email
     * @return boolean
     */
    private function isUserExists($user_name,$email) {
        $stmt = $this->conn->prepare("SELECT customer_id from customers WHERE user_name = ?");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        if($num_rows > 0){
            return true;
        }
        else{
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

    /**
     * Fetching customer by username
     * @param String $user_name
     */
    public function getUserByUsername($user_name) {
        $stmt = $this->conn->prepare("SELECT customer_id, first_name, last_name, api_key, last_login FROM customers WHERE user_name = ?");

        $stmt->bind_param("s", $user_name);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($customer_id, $first_name, $last_name, $api_key, $last_login);
            $stmt->fetch();
            $user = array();
            $user["customer_id"] = $customer_id;
            $user["first_name"] = $first_name;
            $user["last_name"] = $last_name;
            $user["api_key"] = $api_key;
            $user["last_login"] = $last_login;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching all accounts
     * @param String $customer_id
     */
    public function getAllAccounts($customer_id) {
        $stmt = $this->conn->prepare("SELECT account.* FROM accounts account, customers customer WHERE account.customer_id = customer.customer_id AND customer.customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    /**
     * Fetching customer api key
     * @param String $customer_id
     */
    public function getApiKeyById($customer_id) {
        $stmt = $this->conn->prepare("SELECT api_key FROM customers WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($api_key);
            $stmt->close();
            return $api_key;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching customer id by api key
     * @param String $api_key
     */
    public function getCustomerId($api_key) {
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

    /**
     * Validating user api key
     * If the api key is there in db, it is a valid key
     * @param String $api_key user api key
     * @return boolean
     */
    public function isValidApiKey($api_key) {
        $stmt = $this->conn->prepare("SELECT customer_id from customers WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**
     * Generating random Unique MD5 String for user Api key
     */
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }

}

?>

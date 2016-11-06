<?php

require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// User id from db - Global Variable
$customer_id = NULL;

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        $db = new DbHandler();

        // get the api key
        $api_key = $headers['Authorization'];
        // validating api key
        if (!$db->isValidApiKey($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $customer_id;
            $customer_id = $db->getCustomerId($api_key);
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Customer Registration
 * url - /register
 * method - POST
 * params - user name, password, first name, last name, email
 */
$app->post('/register', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('user_name','password','first_name','last_name','email'));

            $response = array();

            // reading post params
            $user_name = $app->request->post('user_name');
            $password = $app->request->post('password');
            $first_name = $app->request->post('first_name');
            $last_name = $app->request->post('last_name');
            $email = $app->request->post('email');
            

            // validating email address
            validateEmail($email);

            $db = new DbHandler();
            $res = $db->createUser($user_name,$password,$first_name,$last_name,$email);

            if ($res == USER_CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "Success";
                echoRespnse(200, $response);
            } else if ($res == USER_CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Failed";
                echoRespnse(201, $response);
            } else if ($res == USER_ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, a user already exists with the provided details";
                echoRespnse(201, $response);
            }
            // echo json response
            
        });

/**
 * User Login
 * url - /login
 * method - POST
 * params - username, password
 */
$app->post('/login', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('user_name', 'password'));

            // reading post params
            $user_name = $app->request()->post('user_name');
            $password = $app->request()->post('password');
            $response = array();

            $db = new DbHandler();
            // check for correct username and password
            if ($db->checkLogin($user_name, $password)) {
                // get the user by username
                $user = $db->getUserByUsername($user_name);

                if ($user != NULL) {
                    $response["error"] = false;
                    $response['customer_id'] = $user['customer_id'];
                    $response['first_name'] = $user['first_name'];
                    $response['last_name'] = $user['last_name'];
                    $response['api_Key'] = $user['api_key'];
                    $response['last_login'] = $user['last_login'];
                } else {
                    // unknown error occurred
                    $response['error'] = true;
                    $response['message'] = "An error occurred. Please try again";
                }
            } else {
                // user credentials are wrong
                $response['error'] = true;
                $response['message'] = 'Login failed. Incorrect credentials';
            }

            echoRespnse(200, $response);
        });

/**
 * Listing all accounts of particual customer
 * method GET
 * url /accounts         
 */
$app->get('/accounts', 'authenticate', function() {
            global $customer_id;
            $response = array();
            $db = new DbHandler();

            // fetching all user tasks
            $result = $db->getAllAccounts($customer_id);

            $response["error"] = false;
            $response["accounts"] = array();

            // looping through result and preparing accounts array
            while ($account = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["account_number"] = $account["account_number"];
                $tmp["customer_id"] = $account["customer_id"];
                $tmp["branch"] = $account["branch"];
                $tmp["account_status"] = $account["account_status"];
                $tmp["account_type"] = $account["account_type"];
                $tmp["account_balance"] = $account["account_balance"];
                array_push($response["accounts"], $tmp);
            }

            echoRespnse(200, $response);
        });

/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();
?>
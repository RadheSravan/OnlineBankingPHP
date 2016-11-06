<?php

require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$customer_id = NULL;

function authenticate(\Slim\Route $route)
{
    
    $headers  = apache_request_headers();
    $response = array();
    $app      = \Slim\Slim::getInstance();
    
    if (isset($headers['Authorization'])) {
        
        $db      = new DbHandler();
        $api_key = $headers['Authorization'];
        
        if (!$db->isValidApiKey($api_key)) {
            $response["error"]   = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoResponse(401, $response);
            $app->stop();
        } else {
            global $customer_id;
            $customer_id = $db->getCustomerId($api_key);
        }
    } else {
        $response["error"]   = true;
        $response["message"] = "Api key is misssing";
        echoResponse(400, $response);
        $app->stop();
    }
}

$app->post('/register', function() use ($app)
{
    
    verifyRequiredParams(array(
        'user_name',
        'password',
        'first_name',
        'last_name',
        'email'
    ));
    
    $response = array();
    
    $user_name  = $app->request->post('user_name');
    $password   = $app->request->post('password');
    $first_name = $app->request->post('first_name');
    $last_name  = $app->request->post('last_name');
    $email      = $app->request->post('email');
    
    validateEmail($email);
    
    $db  = new DbHandler();
    $res = $db->createUser($user_name, $password, $first_name, $last_name, $email);
    
    if ($res == 0) {
        $response["error"]   = false;
        $response["message"] = "Success";
        echoResponse(200, $response);
    } else if ($res == 1) {
        $response["error"]   = true;
        $response["message"] = "Failed";
        echoResponse(201, $response);
    } else if ($res == 2) {
        $response["error"]   = true;
        $response["message"] = "Sorry, a user already exists with the provided details";
        echoResponse(201, $response);
    }
});

$app->post('/login', function() use ($app)
{
    verifyRequiredParams(array(
        'user_name',
        'password'
    ));
    
    $user_name = $app->request()->post('user_name');
    $password  = $app->request()->post('password');
    $response  = array();
    
    $db = new DbHandler();
    
    if ($db->checkLogin($user_name, $password)) {
        
        $user = $db->getUserByUsername($user_name);
        
        if ($user != NULL) {
            $response["error"]       = false;
            $response['customer_id'] = $user['customer_id'];
            $response['first_name']  = $user['first_name'];
            $response['last_name']   = $user['last_name'];
            $response['api_Key']     = $user['api_key'];
            $response['last_login']  = $user['last_login'];
        } else {
            $response['error']   = true;
            $response['message'] = "An error occurred. Please try again";
        }
    } else {
        $response['error']   = true;
        $response['message'] = 'Login failed. Incorrect credentials';
    }
    echoResponse(200, $response);
});

$app->get('/accounts', 'authenticate', function()
{
    global $customer_id;
    $response = array();
    $db       = new DbHandler();
    
    $result = $db->getAllAccounts($customer_id);
    
    $response["error"]    = false;
    $response["accounts"] = array();
    
    while ($account = $result->fetch_assoc()) {
        $tmp                    = array();
        $tmp["account_number"]  = $account["account_number"];
        $tmp["customer_id"]     = $account["customer_id"];
        $tmp["branch"]          = $account["branch"];
        $tmp["account_status"]  = $account["account_status"];
        $tmp["account_type"]    = $account["account_type"];
        $tmp["account_balance"] = $account["account_balance"];
        array_push($response["accounts"], $tmp);
    }
    
    echoResponse(200, $response);
});

$app->post('/announcements', function() use ($app)
{
    
    verifyRequiredParams(array(
        'announcement'
    ));
    
    $response = array();
    
    $announcement = $app->request->post('announcement');
    
    $db  = new DbHandler();
    $res = $db->createAnnouncement($announcement);
    
    if ($res == 0) {
        $response["error"]   = false;
        $response["message"] = "Success";
        echoResponse(200, $response);
    } else if ($res == 1) {
        $response["error"]   = true;
        $response["message"] = "Failed";
        echoResponse(201, $response);
    }
});

$app->get('/announcements', function()
{
    
    $response = array();
    $db       = new DbHandler();
    
    $result = $db->getAllAnnouncements();
    
    $response["error"]         = false;
    $response["announcements"] = array();
    
    while ($announcement = $result->fetch_assoc()) {
        $tmp                    = array();
        $tmp["announcement_id"] = $announcement["announcement_id"];
        $tmp["announcement"]    = $announcement["announcement"];
        array_push($response["announcements"], $tmp);
    }
    
    echoResponse(200, $response);
});

$app->put('/announcements/:id', function($announcement_id) use ($app)
{
    verifyRequiredParams(array(
        'announcement'
    ));
    
    $announcement = $app->request->put('announcement');
    
    $db       = new DbHandler();
    $response = array();
    
    $result = $db->updateAnnouncement($announcement_id, $announcement);
    if ($result) {
        $response["error"]   = false;
        $response["message"] = "Announcement updated successfully";
        echoResponse(200, $response);
    } else {
        $response["error"]   = true;
        $response["message"] = "Failed to update announcement. Try again later!";
        echoResponse(201, $response);
    }
    
});

$app->delete('/announcements/:id', function($announcement_id) use ($app)
{
    $db = new DbHandler();
    
    $response = array();
    $result   = $db->deleteAnnouncement($announcement_id);
    
    if ($result) {
        $response["error"]   = false;
        $response["message"] = "Announcement deleted succesfully";
    } else {
        $response["error"]   = true;
        $response["message"] = "Failed to delete the announcement. Try again later!";
    }
    echoResponse(200, $response);
});


function verifyRequiredParams($required_fields)
{
    $error          = false;
    $error_fields   = "";
    $request_params = array();
    $request_params = $_REQUEST;
    
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
        $response            = array();
        $app                 = \Slim\Slim::getInstance();
        $response["error"]   = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);
        $app->stop();
    }
}

function validateEmail($email)
{
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"]   = true;
        $response["message"] = 'Email address is not valid';
        echoResponse(400, $response);
        $app->stop();
    }
}

function echoResponse($status_code, $response)
{
    
    $app = \Slim\Slim::getInstance();
    
    $app->status($status_code);
    $app->contentType('application/json');
    
    echo json_encode($response);
}

$app->run();
?>
<?php
$user_name = $_POST["username"];
$password  = $_POST["password"];

$service_url    = 'http://localhost/OnlineBankingPHP/REST/v1/login';
$curl           = curl_init($service_url);
$curl_post_data = array(
    'user_name' => $user_name,
    'password'  => $password
);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('Error occured during curl execution. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response, true);
if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('Error occured: ' . $decoded->response->errormessage);
}
if ($decoded['error']) {
    echo $decoded['message'];
} else {
	session_start();
	$_SESSION["last_login"] = date('l, jS F Y, h:i A', strtotime($decoded['last_login']));
	$_SESSION["name"] = $decoded['first_name'].' '.$decoded['last_name'];
	$_SESSION["api_key"] = $decoded['api_Key'];
    header('Location: homepage.php');
}
?>
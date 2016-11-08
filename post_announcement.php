<?php
$announcement   = $_POST["announcement"];
$service_url    = 'http://localhost/OnlineBankingPHP/REST/v1/announcements';
$curl           = curl_init($service_url);
$curl_post_data = array(
    'announcement' => $announcement
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

print_r($decoded['message']);
?>
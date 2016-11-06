<?php
$announcement_id = $_POST["announcement_id"];
$service_url     = 'http://localhost/OnlineBankingPHP/REST/v1/announcements/' . $announcement_id;
$curl            = curl_init($service_url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");

$response = curl_exec($curl);

if ($response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('Error occured during curl execution. Additioanl info: ' . var_export($info));
}

curl_close($curl);

$decoded = json_decode($response, true);

if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('Error occured: ' . $decoded->response->errormessage);
}

print_r($decoded['message']);
?>
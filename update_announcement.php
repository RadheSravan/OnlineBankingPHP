<?php
$announcement_id = $_POST["announcement_id"];
$announcement    = $_POST["announcement"];
$service_url     = 'http://localhost/OnlineBankingPHP/REST/v1/announcements/' . $announcement_id;
$curl            = curl_init($service_url);
$data            = array(
    "announcement" => $announcement
);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

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
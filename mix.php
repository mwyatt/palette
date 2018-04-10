<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'vendor/autoload.php';

$guzzle = new \GuzzleHttp\Client;
try {
    $result = $guzzle->request('POST', 'http://trycolors.com/handler.php', [
        'form_params' => [
            'key' => $_POST['key'],
            'type' => $_POST['type'],
            'input' => $_POST['input'],
        ]
    ]);
    if ($result->getStatusCode() !== 200) {
        throw new \Exception("Bad Request.");
    }
} catch (\Exception $e) {
    echo '<pre>'; print_r($e->getMessage()); print_r($e->getTraceAsString()); echo '</pre>'; exit;
}

$result = json_decode($result->getBody());
echo json_encode($result->hex);

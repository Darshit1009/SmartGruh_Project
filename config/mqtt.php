<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

function getMqttClient()
{
    $server = $_ENV['MQTT_HOST']; // e.g., 'broker.hivemq.com'
    $port = 8883; // Standard port for secure MQTT

    $clientId = 'php-dashboard-' . rand(1000, 9999);

    $connectionSettings = (new ConnectionSettings)
        ->setUsername($_ENV['MQTT_USER'])
        ->setPassword($_ENV['MQTT_PASS'])
        ->setUseTls(true) // Enable this for secure connections
        ->setTlsVerifyPeer(false); // Set to true if you have a valid CA cert

    $mqtt = new MqttClient($server, $port, $clientId);
    $mqtt->connect($connectionSettings, true);

    return $mqtt;
}
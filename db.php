<?php
require 'vendor/autoload.php'; 

$client = new MongoDB\Client("mongodb://localhost:27017");
$database = $client->industrial_park;
$usersCollection = $database->users;
$staffCollection = $database->staff;
// $industryCollection = $database->industry;
// $clientCollection = $database->client;
// $landCollection = $database->land;
// $rawMaterialCollection = $database->raw_material;

?>

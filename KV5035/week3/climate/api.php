<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
 
// import the code from climate_data.php
require_once 'climate_data.php';
 
// call the function from the imported file
$message = climate_data();
 
echo json_encode($message);
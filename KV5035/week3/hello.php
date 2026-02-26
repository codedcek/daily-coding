<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
 
// import the code from data.php
require_once 'data.php';
 
// call the function from the imported file
$message = data();
 
echo json_encode($message);
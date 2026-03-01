<?php
 
header('Content-Type: application/json');
$allHeaders = getallheaders();
 
// convert header keys to lowercase for case-insensitive access
$allHeaders = array_change_key_case($allHeaders, CASE_LOWER);
 
// check for the presence of the authorization header
if (array_key_exists('authorization', $allHeaders)) {
    $authorizationHeader = $allHeaders['authorization'];
} else {
    http_response_code(401);
    exit("Authorization Header Not Found");
}
 
// extract the API key from the Authorization header
$api_key = str_replace('Bearer ', '', $authorizationHeader);
 
echo json_encode($api_key);
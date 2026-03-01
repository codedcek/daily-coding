<?php
 
// set response headers
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Content-Type: application/json');

// load credentials — API key is stored here, not hardcoded
require_once __DIR__ . '/database/credentials.php';

// get the request headers
$allHeaders = getallheaders();

// convert header keys to lowercase for case-insensitive access
$allHeaders = array_change_key_case($allHeaders, CASE_LOWER);

// check for the presence of the Authorization header
if (array_key_exists('authorization', $allHeaders)) {
    $authorizationHeader = $allHeaders['authorization'];
} else {
    http_response_code(401);
    exit("Authorization Header Not Found");
}

// extract the API key from the Authorization header
$api_key = str_replace('Bearer ', '', $authorizationHeader);

if ($api_key !== $api_key_value) {
    http_response_code(401);
    exit("Invalid API Key");
}

// The rest of the API logic would go here...

// read the URL to work out which endpoint was requested
$url      = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$endpoint = trim(str_replace('/KV5035/week3/api.php', '', $url), '/');

switch ($endpoint) {
    case 'actor':
        require_once 'actors.php';
        break;

    case 'film':
        require_once 'films.php';
        break;
    case 'language':
        require_once 'language.php';
        break;

    default:
        http_response_code(404);
        echo json_encode("Endpoint not found. Try /actor or /film");
        break;
}
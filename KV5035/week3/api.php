<?php
 
// set response headers
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Content-Type: application/json');

// load credentials — API key is stored here, not hardcoded
require_once 'exception_handler.php';
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
$endpoint = parse_url($_SERVER["REQUEST_URI"])['path'];

switch ($endpoint) {
    case '/KV5035/week3/actors':
        require_once 'actors.php';
        break;
    case '/KV5035/week3/films':
        require_once 'films.php';
        break;
    case '/KV5035/week3/language':
        require_once 'language.php';
        break;
    default:
        throw new Exception("Endpoint not found", 404);
        break;
}
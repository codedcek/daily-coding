<?php
/** 
 * Language API Endpoint Router
 * 
 * This script routes incoming requests to the correct handler
 * based on the HTTP request method.
 * 
 * @author Chisom Kalu and w21067759
 */

// Tell the browser to expect JSON back
header('Content-Type: application/json');
// Allow requests from any domain (CORS)
header('Access-Control-Allow-Origin: *');
// List all HTTP methods this endpoint supports
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
// Allow Content-Type header in requests
header('Access-Control-Allow-Headers: Content-Type');

// Get the HTTP method used in the request e.g. GET, POST, DELETE
$request_method = $_SERVER['REQUEST_METHOD'];

// Route the request to the correct handler file based on the method
switch ($request_method) {
    case 'GET':
        // Load and call the GET handler to retrieve languages
        require_once 'GET_language.php';
        GET_language();
        break;
    case 'POST':
        // Load and call the POST handler to add a new language
        require_once 'POST_language.php';
        POST_language();
        break;
    case 'PUT':
    require_once 'PUT_language.php';
    PUT_language();
    break;
case 'PATCH':
    require_once 'PUT_language.php'; // same file!
    PATCH_language();
    break;
    case 'DELETE':
        // Load and call the DELETE handler to remove a language
        require_once 'DELETE_language.php';
        DELETE_language();
        break;
    case 'OPTIONS':
        // OPTIONS is sent by browsers as a preflight check before CORS requests
        // We just return 200 OK to confirm the endpoint is available
        http_response_code(200);
        break;
    default:
        // Any other method is not allowed - return 405 status
        http_response_code(405);
        echo json_encode("Method Not Allowed");
        break;
}
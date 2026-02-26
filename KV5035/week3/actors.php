<?php
 
/** 
 * Actors API Endpoint
 * 
 * This script returns a list of actors in JSON format.
 * It supports filtering by actor_id and pagination.
 * 
 * @author John Rooksby
 * @author Maria Salama
 * @author Dan Hodgson
 * @author Jonathan Sanderson
 * @author Chisom Kalu and w21067759
 */
 
 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE');
 
 
$request_method = $_SERVER['REQUEST_METHOD'];
 
 
switch ($request_method) {
    case 'GET':
        require_once 'GET_actors.php';
        GET_actors();
        break;
    case 'POST':
        require_once 'POST_actors.php';
        POST_actors();
        break;
    case 'PUT':
    case 'PATCH':
        require_once 'PUT_actors.php';
        PUT_actors();
        break;
    case 'DELETE':
        require_once 'DELETE_actors.php';
        DELETE_actors();
        break;
    case 'OPTIONS':
        // Response code 200 means OK
        http_response_code(200);
        break;
    default:
        // Response code 405 means method not allowed
        http_response_code(405);
        echo json_encode("Method Not Allowed");
        break;
}
<?php
/** 
 * Handle POST requests for actors
 * 
 * This script inserts a new actor into the database.
 * A first_name and last_name are required.
 * 
 * @author John Rooksby
 * @author Maria Salama
 * @author Dan Hodgson
 * @author Jonathan Sanderson
 * @author Chisom Kalu and w21067759
 */
function POST_actors() {
 
    require_once 'database/execute_sql.php';
    
    /**
     * The SQL insert statement.
     */
    $sql = "INSERT INTO actor (first_name, last_name) VALUES (:first_name, :last_name)";
 
    $request_body = file_get_contents('php://input');
    $request_body = json_decode($request_body, true);
    
    if (array_key_exists('first_name', $request_body)) {
        $first_name = $request_body['first_name'];
    } else {
        http_response_code(400);
        echo json_encode("Error: first_name is required");
        exit();
    }
    
    if (array_key_exists('last_name', $request_body)) {
        $last_name = $request_body['last_name'];
    } else {
        http_response_code(400);
        echo json_encode("Error: last_name is required");
        exit();
    }
 
    $param = [
        ':first_name' => $first_name,
        ':last_name' => $last_name
    ];
    
    $data = execute_SQL($sql, $param); 
    echo json_encode($data);
}

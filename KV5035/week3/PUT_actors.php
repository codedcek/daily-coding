<?php
/** 
 * Handle PUT and PATCH requests for actors
 * 
 * This script updates actors in the database.
 * A first_name and last_name are required.
 * 
 * @author John Rooksby
 * @author Maria Salama
 * @author Dan Hodgson
 * @author Jonathan Sanderson
 * @author Chisom Kalu and w21067759
 */
function PUT_actors() {
 
    require_once 'database/execute_sql.php';
    
    /**
     * The SQL update statement.
     */
    $sql = "UPDATE actor 
            SET first_name = :first_name, last_name = :last_name 
            WHERE actor_id = :actor_id";
 
    $request_body = file_get_contents('php://input');
    $request_body = json_decode($request_body, true);
    
    if (array_key_exists('actor_id', $request_body)) {
        $actor_id = $request_body['actor_id'];
    } else {
        http_response_code(400);
        echo json_encode("Error: actor_id is required");
        exit();
    }
 
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
        ':actor_id' => $actor_id,
        ':first_name' => $first_name,
        ':last_name' => $last_name
    ];
    
    $data = execute_SQL($sql, $param); 
    echo json_encode($data);
}
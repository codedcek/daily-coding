<?php
/** 
 * Handle DELETE requests for actors
 * 
 * This script deletes actors from the database.
 * An actor_id is required.
 * 
 * @author John Rooksby
 * @author Maria Salama
 * @author Dan Hodgson
 * @author Jonathan Sanderson
 * @author Chisom Kalu and w21067759
 */
function DELETE_actors() {
 
    require_once 'database/execute_sql.php';
    
    /**
     * The SQL delete statement.
     */
    $sql = "DELETE FROM actor WHERE actor_id = :actor_id";
 
    $request_body = file_get_contents('php://input');
    $request_body = json_decode($request_body, true);
    
    if (array_key_exists('actor_id', $request_body)) {
        $actor_id = $request_body['actor_id'];
    } else {
        http_response_code(400);
        echo json_encode("Error: actor_id is required");
        exit();
    }
 
    $param = [
        ':actor_id' => $actor_id,
    ];
    
    $data = execute_SQL($sql, $param); 
    echo json_encode($data);
}
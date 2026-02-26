<?php
/** 
 * Handle GET requests for actors
 * 
 * This function returns a list of actors in JSON format.
 * It supports filtering by id, actor_id and pagination.
 * 
 * @author John Rooksby
 * @author Maria Salama
 * @author Dan Hodgson
 * @author Jonathan Sanderson
 * @author Chisom Kalu and w21067759
 */
function GET_actors() {
 
    require_once 'database/execute_sql.php';
    
    /**
     * The base SQL query to get the actors.
     */
    $sql = "SELECT DISTINCT actor.actor_id AS id, actor.first_name, actor.last_name 
            FROM actor
            LEFT JOIN film_actor ON (actor.actor_id = film_actor.actor_id)
            WHERE 1=1";
    
    /**
     * Get the parameters from the URL. We use the null coalescing operator (??) 
     * to set a default value of an empty string if the parameter is not provided.
     */
    $id = $_GET['id'] ?? '';
    $page = $_GET['page'] ?? '';
    $size = $_GET['size'] ?? '';
    $actor_id = $_GET['actor_id'] ?? '';
    
    /**
     * We will use an associative array to hold the 'where' params for the SQL 
     * query. This will be passed to the execute_SQL function.
     */
    $param = [];
    
    // Is there an id parameter?
    if (!empty($id)) {
        $sql .= " AND actor.actor_id = :id";
        $param[':id'] = $id;
    }
 
    // Is there an actor_id parameter?
    if (!empty($actor_id)) {
        $sql .= " AND actor.actor_id = :actor_id";
        $param[':actor_id'] = $actor_id;
    }
 
    // Is there a page parameter?
    if (!empty($page) || $page === '0') {
    
        // Check if the page parameter is not numeric
        if (!is_numeric($page)) {
            echo json_encode("Page parameter must be an integer");
            exit();
        }
    
        // Check if the page number is zero or lower
        if ($page <= 0) {
            echo json_encode("Page parameter must be greater than 0");
            exit();
        }
    
        // Is there a size parameter (only used if page is provided)
        if (!empty($size ) || $size === '0') {
    
            // Check if the size parameter is not numeric
            if (!is_numeric($size)) {
                http_response_code(400);
                echo json_encode("Size parameter must be an integer");
                exit();
            }
    
            // Check if the page number is zero or lower
            if ($size <= 0) {
                http_response_code(400);
                echo json_encode("Size parameter must be greater than 0");
                exit();
            }
        } else {
            // Use default size 10
            $size = 10;
        }
    
        // Calculate an OFFSET using the page number and size
        $offset = ($page - 1) * $size;
        
        $sql .= " ORDER BY id LIMIT $size OFFSET $offset";
    }
    
    $data = execute_SQL($sql, $param); 
    echo json_encode($data);
}
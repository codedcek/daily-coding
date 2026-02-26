<?php
/** 
 * Handle GET requests for languages
 * 
 * This function returns a list of languages in JSON format.
 * It supports filtering by id.
 * 
 * @author Chisom Kalu and w21067759
 */
function GET_language() {
    // Import the execute_SQL function from the database folder
    require_once 'database/execute_sql.php';

    // Base SQL query - WHERE 1=1 allows us to safely append AND conditions later
    $sql = "SELECT language_id AS id, name, last_update FROM language WHERE 1=1";

    // Empty array to hold any SQL parameters we need to bind
    // This prevents SQL injection attacks
    $param = [];

    // Get the id parameter from the URL using null coalescing operator (??)
    // If not provided, default to empty string
    $id = $_GET['id'] ?? '';

    // If an id was provided, add it as a WHERE condition
    // e.g. language.php?id=2 will only return language with id 2
    if (!empty($id)) {
        $sql .= " AND language_id = :id";
        $param[':id'] = $id;
    }

    // Execute the SQL query and return results as JSON
    $data = execute_SQL($sql, $param);
    echo json_encode($data);
}
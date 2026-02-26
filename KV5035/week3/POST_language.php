<?php
/** 
 * Handle POST requests for languages
 * 
 * This function inserts a new language into the database.
 * A name is required.
 * 
 * @author Chisom Kalu and w21067759
 */
function POST_language() {
    // Import the execute_SQL function from the database folder
    require_once 'database/execute_sql.php';

    // SQL INSERT statement to add a new language
    // Named parameter :name prevents SQL injection
    $sql = "INSERT INTO language (name) VALUES (:name)";

    // Read the raw request body and decode it from JSON into a PHP array
    $request_body = file_get_contents('php://input');
    $request_body = json_decode($request_body, true);

    // *** NULL CHECK - prevents crash when no body is sent with the request ***
    if (empty($request_body) || !is_array($request_body)) {
        http_response_code(400);
        echo json_encode("Error: request body is required");
        exit();
    }
    // *** END NULL CHECK ***

    // Check name was provided in the request body
    if (array_key_exists('name', $request_body)) {
        $name = $request_body['name'];
    } else {
        http_response_code(400);
        echo json_encode("Error: name is required");
        exit();
    }

    // Bind the parameter to the SQL query
    $param = [':name' => $name];

    // Execute the INSERT and return the result as JSON
    $data = execute_SQL($sql, $param);
    echo json_encode($data);
}
<?php
/** 
 * Handle DELETE requests for languages
 * 
 * This function deletes a language from the database.
 * language_id is required to identify which record to delete.
 * 
 * @author Chisom Kalu and w21067759
 */
function DELETE_language() {
    // Import the execute_SQL function from the database folder
    require_once 'database/execute_sql.php';

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

    // language_id is required to know which language to delete
    if (array_key_exists('language_id', $request_body)) {
        $language_id = $request_body['language_id'];
    } else {
        http_response_code(400);
        echo json_encode("Error: language_id is required");
        exit();
    }

    // SQL DELETE statement - WHERE ensures we only delete the correct record
    $sql = "DELETE FROM language WHERE language_id = :language_id";
    $param = [':language_id' => $language_id];

    // Execute the DELETE and return the result as JSON
    $data = execute_SQL($sql, $param);
    echo json_encode($data);
}
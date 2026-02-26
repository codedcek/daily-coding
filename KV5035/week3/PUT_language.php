<?php
/** 
 * Handle PUT and PATCH requests for languages
 * 
 * PUT replaces the entire language record - all fields required.
 * PATCH partially updates a language - only provided fields are updated.
 * 
 * @author Chisom Kalu and w21067759
 */
function PUT_language() {
    // Import the execute_SQL function from the database folder
    require_once 'database/execute_sql.php';

    // SQL UPDATE statement - replaces the name of the language
    // WHERE language_id ensures we only update the correct language
    $sql = "UPDATE language SET name = :name WHERE language_id = :language_id";

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

    // PUT requires language_id to identify which language to update
    if (array_key_exists('language_id', $request_body)) {
        $language_id = $request_body['language_id'];
    } else {
        http_response_code(400);
        echo json_encode("Error: language_id is required");
        exit();
    }

    // PUT requires name - it must replace the full record
    if (array_key_exists('name', $request_body)) {
        $name = $request_body['name'];
    } else {
        http_response_code(400);
        echo json_encode("Error: name is required");
        exit();
    }

    // Bind both parameters to the SQL query
    $param = [
        ':language_id' => $language_id,
        ':name' => $name
    ];

    // Execute the UPDATE and return the result as JSON
    $data = execute_SQL($sql, $param);
    echo json_encode($data);
}

function PATCH_language() {
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

    // PATCH always needs language_id to know which record to update
    if (array_key_exists('language_id', $request_body)) {
        $language_id = $request_body['language_id'];
    } else {
        http_response_code(400);
        echo json_encode("Error: language_id is required");
        exit();
    }

    // Build the SQL dynamically - only update fields that were provided
    // This is what makes PATCH different from PUT
    $fields = [];
    $param = [':language_id' => $language_id];

    // If name was provided, add it to the update
    if (array_key_exists('name', $request_body)) {
        $fields[] = "name = :name";
        $param[':name'] = $request_body['name'];
    }

    // If no fields were provided, there is nothing to update
    if (empty($fields)) {
        http_response_code(400);
        echo json_encode("Error: nothing to update");
        exit();
    }

    // Build the final SQL using only the fields that were provided
    // implode joins the fields array with commas
    $sql = "UPDATE language SET " . implode(", ", $fields) . " WHERE language_id = :language_id";

    // Execute the UPDATE and return the result as JSON
    $data = execute_SQL($sql, $param);
    echo json_encode($data);
}
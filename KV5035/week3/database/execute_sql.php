<?php
/** 
 * Execute an SQL query
 * 
 * This function executes an SQL query and returns the results as an array. 
 * It uses the database connection function to connect to the database and 
 * prepares and executes the SQL query using PDO. If there is an error, it 
 * returns a JSON-encoded error message.
 * 
 * @author John Rooksby
 * @author Maria Salama
 * @author Dan Hodgson
 * @author Jonathan Sanderson
 * @author Chisom Kalu and W21067759
 * 
 * @param string $sql The SQL query to execute
 * @param array $param An associative array of parameters to bind to the SQL query
 * @return array The results of the SQL query as an associative array
 * 
 * @version 2026-week4
 * @generated Claude was used to review this code
 */
function execute_SQL($sql = "", $param = []) {
    // Import the database connection function. Adding _DIR_ at the start
    // means PHP will look in the same folder as the current script
    require_once __DIR__."/database_connection.php";
    
    try {
        // connect to the database
        $conn = database_connection();
        // prepare and execute the SQL statement, passing in the parameters
        $result = $conn->prepare($sql);
        $result->execute($param); 
        // fetch the results as an associative array and return it
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        return $data;
 
    } catch( PDOException $e ) {
        // If there is an exception, output the error message
        $error = "SQL Error: " . $e->getMessage();
        echo json_encode($error);
        exit();
    }
}
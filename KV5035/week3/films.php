<?php

/** 
 * Films file 
 * 
 * This function executes films file and returns the results as an array. 
 * It uses the database connection function to connect to the database.
 * Supports filtering by actor_id via JOIN with film_actor table.
 * 
 * @author John Rooksby
 * @author Maria Salama
 * @author Dan Hodgson
 * @author Jonathan Sanderson
 * @author Chisom Kalu and W21067759
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'database/execute_sql.php';

// Add a where clause to the SQL query 
$sql = "SELECT DISTINCT film.film_id AS id, title, description, release_year, 
        language.name AS language, category.name AS category, rating, length
        FROM film 
        JOIN language ON film.language_id = language.language_id
        JOIN category ON film.category_id = category.category_id";

// Access the parameters from the URL
$search = $_GET['search'] ?? '';
$id = $_GET['id'] ?? '';
$language = $_GET['language'] ?? '';
$category = $_GET['category'] ?? '';
$actor_id = $_GET['actor_id'] ?? '';
$page = $_GET['page'] ?? '';
$size = $_GET['size'] ?? '';

// Link the SQL params to the URL parameters
$param = [];

// If actor_id is provided, JOIN the film_actor table to filter films by actor
if (!empty($actor_id)) {
    $sql .= " JOIN film_actor ON film.film_id = film_actor.film_id";
}

// Add the WHERE clause
$sql .= " WHERE 1=1";

// Add actor_id condition if actor_id parameter is not empty
if (!empty($actor_id)) {
    $sql .= " AND film_actor.actor_id = :actor_id";
    $param[':actor_id'] = $actor_id;
}

// Add search condition if search parameter is not empty
if (!empty($search)) {
    $sql .= " AND (title LIKE :search OR description LIKE :search)";
    $param[':search'] = '%' . $search . '%';
}

// Add id condition if id parameter is not empty
if (!empty($id)) {
    $sql .= " AND film_id = :id";
    $param[':id'] = $id;
}

// Add language condition if language parameter is not empty
if (!empty($language)) {
    $sql .= " AND language.name = :language";
    $param[':language'] = $language;
}

// Add category condition if category parameter is not empty
if (!empty($category)) {
    $sql .= " AND category.name = :category";
    $param[':category'] = $category;
}

// PHP counts zero as empty, so we add an explicit check for this
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

    // Default page size is 10
    $limit = 10;

    // Check if size parameter is provided
    if (!empty($size) || $size === '0') {
        // Check if size is not numeric
        if (!is_numeric($size)) {
            echo json_encode("Size parameter must be an integer");
            exit();
        }
        // Check if size is zero or lower
        if ($size <= 0) {
            echo json_encode("Size parameter must be greater than 0");
            exit();
        }
        $limit = (int)$size;
    }

    // Calculate an OFFSET using the page number
    $offset = ($page - 1) * $limit;
    
    // Add an ORDER BY, LIMIT and OFFSET to the SQL statement
    $sql .= " ORDER BY id LIMIT $limit OFFSET $offset";
}

// Make sure to pass $param to this function 
$data = execute_SQL($sql, $param);

echo json_encode($data);
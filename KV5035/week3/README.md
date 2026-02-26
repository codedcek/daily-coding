# KV5035 Software Architecture — Week 3 Practice

**Module:** KV5035 Software Architecture  
**Student:** Chisom Kalu (w21067759)  
**University:** Northumbria University

---

## Overview

This folder contains practice work from Week 3 of the Software Architecture module. The exercises cover building REST API endpoints in PHP, working with a MySQL database using PDO, consuming external APIs with JavaScript, and testing all endpoints using **Postman**.

---

## Projects

### 🎬 Films & Actors REST API
> PHP · MySQL · PDO · REST · JSON

A REST API built on top of the `films_2026` database (a sample film rental dataset). Demonstrates full CRUD operations, filtering, searching and pagination.

**Endpoints:**

| File | Method | Description |
|---|---|---|
| `actors.php` | Router | Routes GET, POST, PUT, PATCH, DELETE, OPTIONS |
| `GET_actors.php` | GET | Returns actors, supports `id`, `actor_id`, `page`, `size` params |
| `POST_actors.php` | POST | Creates a new actor (first_name, last_name required) |
| `PUT_actors.php` | PUT/PATCH | Updates actor first/last name by actor_id |
| `DELETE_actors.php` | DELETE | Removes an actor by actor_id |
| `films.php` | GET | Returns films with filtering by `search`, `id`, `language`, `category`, `actor_id`, pagination |

**Key techniques used:**
- PDO prepared statements for SQL injection prevention
- `LEFT JOIN` to include actors without film associations
- `LIKE` search across multiple columns
- Pagination with `LIMIT` and `OFFSET`
- Null checks to prevent fatal errors on empty request bodies

---

### 🌍 Language API
> PHP · MySQL · PDO · REST · JSON

Full CRUD REST API for the `language` table demonstrating all five HTTP methods.

| File | Method | Description |
|---|---|---|
| `language.php` | Router | Routes GET, POST, PUT, PATCH, DELETE, OPTIONS |
| `GET_language.php` | GET | Returns languages, supports `id` filter |
| `POST_language.php` | POST | Inserts a new language (name required) |
| `PUT_language.php` | PUT | Full update — language_id and name required |
| `PUT_language.php` | PATCH | Partial update — dynamically builds SQL for only provided fields |
| `DELETE_language.php` | DELETE | Removes a language by language_id |

**Notable pattern — dynamic PATCH SQL:**
```php
$sql = "UPDATE language SET " . implode(", ", $fields) . " WHERE language_id = :language_id";
```
This builds the UPDATE statement at runtime using only the fields provided in the request body — the core difference between PUT and PATCH.

---

### 🌡️ Climate Data API
> PHP · JSON · REST

A simple REST API (`api.php` + `climate_data.php`) that returns climate data in JSON format. Demonstrates the separation of data logic from the response layer — the same pattern used across all endpoints in this project.

---

### 🚇 Haymarket Metro Station Display
> JavaScript · REST · Fetch API · HTML · CSS

A live metro train departure board for **Haymarket Station, Newcastle** that fetches real-time data from the Nexus Metro RTI API. Styled to mimic a real station display board.

**Features:**
- Live departure times for Platform 1 and Platform 2
- Auto-refreshes every 30 seconds
- Toggle between platform display view and raw JSON view
- Colour-coded Yellow/Green line badges
- Animated train emoji across the screen
- Error handling for failed API requests

**API used:** `https://metro-rti.nexus.org.uk/api/times/HAY/{platform}`

---

### 👋 Hello API
> PHP · JSON

A simple introductory endpoint (`hello.php` + `data.php`) demonstrating how to separate data logic from the response layer — a foundational pattern used throughout the module.

---

## 🗄️ Database Layer
> PHP · PDO · MariaDB

| File | Description |
|---|---|
| `database/database_connection.php` | Creates and returns a PDO connection to MariaDB with full error handling |
| `database/execute_sql.php` | Executes any SQL query with bound parameters, returns results as array |
| `database/credentials.php` | Database credentials (excluded from Git via `.gitignore`) |

The `execute_SQL()` function is the single point of database interaction across all endpoints — a clean abstraction that keeps SQL logic out of the router files.

---

## 🧪 Testing with Postman

All backend endpoints were tested using **Postman**. Each HTTP method was verified independently:

| Method | What was tested |
|---|---|
| GET | Filtering by id, pagination with page/size params |
| POST | Creating new records with valid and invalid JSON bodies |
| PUT | Full updates with all required fields |
| PATCH | Partial updates with only some fields provided |
| DELETE | Removing records by id, error handling for missing id |

---

## Database

The `films_2026.sql` file contains the schema and data for the films database. Import it into MySQL/MariaDB to run the API locally.

```bash
mysql -u your_username -p your_database < films_2026.sql
```

---

## Running Locally

1. Set up a PHP server (e.g. XAMPP, MAMP, or PHP built-in server)
2. Import `films_2026.sql` into your database
3. Update `database/credentials.php` with your DB details
4. Run: `php -S localhost:8000`
5. Open Postman and test endpoints at `http://localhost:8000`

---

## Skills Demonstrated

- RESTful API design principles
- PHP file organisation (router → handler → database)
- SQL joins, filtering and pagination
- PDO prepared statements
- Dynamic SQL building for partial updates
- JavaScript Fetch API and async/await
- Error handling at both PHP and JS layers
- API testing with Postman

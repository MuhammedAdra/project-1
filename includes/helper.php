<?php
if (!function_exists('db_create')) {
    function db_create($table, array $data)
    {
        // Escape data to prevent SQL Injection
        $columns = array_keys($data);
        $escaped_values = array_map(function ($value) {
            return "'" . mysqli_real_escape_string($GLOBALS['connect'], $value) . "'";
        }, array_values($data));

        // Construct SQL query
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(", ", $columns),
            implode(", ", $escaped_values)
        );

        // Execute query
        if (mysqli_query($GLOBALS['connect'], $sql)) {
            return mysqli_insert_id($GLOBALS['connect']); // Return the inserted ID
        } else {
            die("Database query failed: " . mysqli_error($GLOBALS['connect']));
        }
    }
}

// Example usage
$id = db_create('user', [
    'name' => 'MUHAMMED',
    'email' => 'adra2@gmail.com',
    'password' => '123', // Corrected field name
    'mobile' => '05368385055' // Corrected field name
]);

echo "Inserted record with ID: " . $id;

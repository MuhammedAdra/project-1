<?php
// Load database configuration
$database_info = include __DIR__ . "/../config/database.php";
if (!$database_info || !is_array($database_info)) {
    die("Failed to load database configuration.");
}

// Establish database connection
$GLOBALS['connect'] = mysqli_connect(
    $database_info['servername'],
    $database_info['username'],
    $database_info['password'],
    $database_info['database'],
    $database_info['port']
);

if (!$GLOBALS['connect']) {
    die("Connection failed: " . mysqli_connect_error());
}



include __DIR__ . "/helper.php";

// Close the connection only if it's open
if (isset($GLOBALS['connect']) && $GLOBALS['connect'] !== false) {
    mysqli_close($GLOBALS['connect']);
}

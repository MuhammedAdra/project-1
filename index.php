<?php
require_once __DIR__ . "/includes/app.php";

/*
$result = db_create('user', [
    'name' => 'alir',
    'email' => 'adra44@gmail.com',
    'password' => '1243',
    'mobile' => '053684385055'
]);

if ($result['status'] === 'success') {
    echo "Inserted record with ID: " . $result['id'];
} else {
    echo "Error: " . $result['message'];
}*/


/*
$update = db_update('user', [
    'name' => 'alir',
    'email' => 'adra44@gmail.com',
    'password' => '1243',
    'mobile' => '053684385066',
], 19);

if ($update['status'] === 'success') {
    var_dump($update['data']);
} else {
    echo "Error: " . $update['message'];
}
*/

/*
$result = db_delete('user', 19);

if ($result['status'] === 'success') {
    echo $result['message'];
} else {
    echo "Error: " . $result['message'];
} */

/*

$result = db_fetch('user', 9);

if ($result['status'] === 'success') {
    var_dump($result['data']);
} else {
    echo "Error: " . $result['message'];
}
*/

/*
$search = db_first('user', "WHERE email = 'adra4@gmail.com'");

if ($search['status'] === 'success') {
    var_dump($search['data']);
} else {
    echo "Error: " . $search['message'];
}
*/
/*// Example usage
$user = db_get('user', ""); // Fetch all users
if ($user['status'] === 'success' && $user['num'] > 0) {
    while ($row = mysqli_fetch_assoc($user['query'])) {
        echo $row['name'] . "<br>";
    }
} else {
    echo "No users found or query failed.";
}

if (!empty($GLOBALS['query'])) {
    mysqli_free_result($GLOBALS['query']);
}
*/

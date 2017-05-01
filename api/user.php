<?php
/**
 * filename: user.php
 * author: yusuf shakeel
 * description: this file contains user api
 *
 * note! this is only for demo purpose
 */

//setting header to json
header('Content-Type: application/json');

//database
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root123');
define('DB_NAME', 'mydb');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}

//get parameter
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pagelimit = isset($_GET['pagelimit']) ? intval($_GET['pagelimit']) : 10;
$userid = isset($_GET['userid']) ? $_GET['userid'] : null;

if ($page < 1) {
	$page = 1;
}

if ($pagelimit < 0) {
	$pagelimit = 10;
}

$offset = $page * $pagelimit - $pagelimit;

//query to get data from the table
$query = sprintf("SELECT userid, firstname, lastname FROM user ORDER BY userid");

if (isset($userid)) {
	$query .= sprintf(" WHERE userid = '%s'", $userid);
}

$query .= sprintf("LIMIT %d, %d", $offset, $pagelimit);

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);
<?php

//GIT UPLOAD
$connect_error = '<h1>No database connection right now</h1>'; //send a custom error message
$table_error = '<h1>No table found!</h1>';

define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME', getenv('OPENSHIFT_APP_NAME'));

$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
$dbh = new PDO($dsn, DB_USER, DB_PASS);

?>
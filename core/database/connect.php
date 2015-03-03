<?php

//GIT UPLOAD
$connect_error = '<h1>No database connection right now</h1>'; //send a custom error message
define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME', getenv('OPENSHIFT_APP_NAME'));

try{

    $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
    $db = new PDO($dsn, DB_USER, DB_PASS));
} catch(PDOException $e){
    echo 'ERROR:' . $e->getMessage()
}
//from http://stackoverflow.com/questions/15921169/how-to-connect-to-the-database-in-openshift-application

?>
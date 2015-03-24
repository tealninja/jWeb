<?php

$connect_error = '<h1>No database connection right now</h1>'; //send a custom error message

$local_db = false;

if ($local_db == true){ //use this for development purposes on xampp

    define('DB_HOST', 'localhost');
    define('DB_PORT', '');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'vweb');

    try {
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';port=' . DB_PORT;
        $db = new PDO($dsn, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
        die("<h1>Database problem!</h1>");

    }
} else {

//GIT UPLOAD

    define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
    define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
    define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
    define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
    define('DB_NAME', getenv('OPENSHIFT_APP_NAME'));

    try {
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';port=' . DB_PORT;
        $db = new PDO($dsn, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
        die("Sorry, database problem");

    }

}
//from http://stackoverflow.com/questions/15921169/how-to-connect-to-the-database-in-openshift-application

?>
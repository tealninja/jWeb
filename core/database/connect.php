<?php

//GIT UPLOAD
$connect_error = '<h1>No database connection right now</h1>'; //send a custom error message
$table_error = '<h1>No table found!</h1>';

mysql_connect("vweb","admin5FKc8nS","5e2UT-hVCdbp") or die($connect_error);
mysql_select_db("vweb") or die('no table');
?>
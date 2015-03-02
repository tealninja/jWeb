<?php

//GIT UPLOAD
$connect_error = 'No database connection right now'; //send a custom error message

mysql_connect("vweb-tealninja.rhcloud.com","admin5FKc8nS","5e2UT-hVCdbp") or die($connect_error);
mysql_select_db("vweb") or die('no table');
?>
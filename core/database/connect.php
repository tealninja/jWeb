<?php
$connect_error = 'Sorry bro'; //send a custom error message

mysql_connect("localhost","root","") or die($connect_error);
mysql_select_db("lr") or die('no table');
?>
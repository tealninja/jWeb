<?php 
session_start();
error_reporting(0);

require 'database/connect.php';
require 'functions/general.php';
require 'functions/users.php';

$current_file = end(explode('/', $_SERVER['SCRIPT_NAME']));

if(logged_in() === true) {
    $session_user_id = $_SESSION['user_id'];
    $user_data = user_data($session_user_id, 'user_id', 'username', 'password', 'first_name','last_name', 'email', 'password_recover', 'type', 'allow_email', 'profile');
    if(user_active($user_data['username']) === false){
        session_destroy();
        header('Location: index.php?force');
        exit(); 
    }
    
    if ($current_file !== 'changepassword.php' && $current_file !== 'logout.php' && $user_data['password_recover'] == 1) {
        header('Location: changepassword.php');
    }
}

$errors = array();

?>
<?php

function submit_quick_report($user_id, $report_data) {
    //built from the register fucntions
    //$report_data['user_id'] = $user_id;
    array_walk($report_data, 'array_sanitize');
    $fields = array_keys($report_data);
    $placeholders = $fields;
    foreach($placeholders as &$value){
        $value = ':' . $value;
    }
    $fields = (implode(', ',$fields));
    // REF ("INSERT INTO user (`username`, `password`, `first_name`, `last_name`, `email`, `email_code`) VALUES (:username, :password, :first_name, :last_name, :email, :email_code)");
    global $db;
    $stmt = $db->prepare("INSERT INTO quick_reports (" . $fields . ")  VALUES (" . implode(' ,', $placeholders) . ")");
    print_r($stmt);
    print_r('<br>');
    try {
        $stmt->execute($report_data);
    } catch (PDOException $e) {
        echo $e->getMessage();
        die("<h1>Database problem!</h1>");
    }

    //mysql_query("INSERT INTO `quick_reports` ($fields) VALUES ($data)");
    //consider sending an email to the user to confirm tha the data has been submitted. Or other users.
}

function upload_csv_file($user_id, $file_temp, $file_extn) {
    $file_path = 'data/' . substr(md5(time()),0,10) . '.' . $file_extn;
    move_uploaded_file($file_temp, $file_path);
    mysql_query("UPDATE `user` SET `profile` = '" .  mysql_real_escape_string($file_path) . "' WHERE `user_id` = " . (int)$user_id);
}

function change_profile_image($user_id, $file_temp, $file_extn){
    //upload file then perform query to update the path
    $file_path = 'images/profile/' . substr(md5(time()),0,10) . '.' . $file_extn;
    move_uploaded_file($file_temp, $file_path);
    mysql_query("UPDATE `user` SET `profile` = '" .  mysql_real_escape_string($file_path) . "' WHERE `user_id` = " . (int)$user_id);
}

function mail_users($subject, $body) {
$query = mysql_query("SELECT `email`, `first_name` FROM `user` WHERE `allow_email` = 1");
    while (($row = mysql_fetch_assoc($query)) !==false) {
        $body_text = "Hello " . $row['first_name'] . ",\n\n" . $body;
        email($row['email'], $subject, $body_text);
    }
}


function has_access($user_id, $type) {
    $user_id    = (int)($user_id);
    $type       = (int)$type;
    global $db;
    $stmt = $db->prepare("SELECT (`type`) from user WHERE user_id = :user_id");
    $stmt->bindParam(':user_id',$user_id);
    //$stmt->bindParam(':type',$type);
    $stmt->execute();
    $result = $stmt->fetch();// == 1) ? true : false;
    return ((int)$result['type'] == $type) ? true : false;
}

function recover($mode, $email) {
    $mode   = sanitize($mode);
    $email  = sanitize($email);
    $user_data = user_data(user_id_from_email($email), 'first_name', 'username', 'user_id');
    
    if ($mode == 'username') {
        email($email, 'Your username', "Hello, " . $user_data['first_name'] . ", your username is " . $user_data['username']);
    } else if ($mode == 'password') {
        $generated_password = substr(md5(rand(999,999999)),0,8);
        change_password($user_data['user_id'], $generated_password);
        update_user($user_data['user_id'], array('password_recover' =>'1'));
        email($user_data['email'],'Your password recovery',"hello " . $user_data['user_id'] . ', your new password is ' . $generated_password . "\n-admin");
    }
}

function update_user($user_id, $update_data) {
    
    $update = array();
    array_walk($update_data, 'array_sanitize');
    
    foreach($update_data as $field =>$data) {
        $update[] = '`' . $field . '`' . ' = \'' . $data . '\'';
    }

    mysql_query("UPDATE `user` SET" . implode(', ', $update) . "WHERE `user_id` = $user_id") or die(mysql_error());
    echo ' finished q';
}

function activate($email, $email_code) {
    //do we need to sanitize thed data?!
    global $db;
    $stmt = $db->prepare("SELECT COUNT(user_id) FROM user WHERE email = :email and email_code = :email_code AND active = 0");
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':email_code', $email_code);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result['COUNT(user_id)'] == 1) {
        $stmt = $db->prepare("UPDATE user SET active = 1 WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return true;
    } else {
        return false;
    }

}
function change_password($user_id, $password) {
    $user_id = (int)$user_id;
    $password = md5($password);
    global $db;
    $stmt = $db->prepare("UPDATE user SET password = :password, password_recover = 0 WHERE user_id = :user_id");
    $stmt->bindParam(':password',$password);
    $stmt ->bindParam(':user_id', $user_id);
    $stmt->execute();

}

function register_user($register_data){
    //has the pw. need to update to sha1 min #security
    $register_data['password'] =md5($register_data['password']);

    global $db;
    //prepare query
    $query = $db->prepare("INSERT INTO user (`username`, `password`, `first_name`, `last_name`, `email`, `email_code`) VALUES (:username, :password, :first_name, :last_name, :email, :email_code)");

    //bind parameters -- can i do this in a loop? I think i have to execute separate queries using foreach
    $query->bindParam(":username", $register_data['username']);
    $query->bindParam(":password", $register_data['password']);
    $query->bindParam(":first_name", $register_data['first_name']);
    $query->bindParam(":last_name", $register_data['last_name']);
    $query->bindParam(":last_name", $register_data['last_name']);
    $query->bindParam(":email", $register_data['email']);
    $query->bindParam(":email_code", $register_data['email_code']);
    $query->execute();

    email($register_data['email'], 'Activate you account',"Hello" .
        $register_data['first_name'] .
        "\nYou need to activate your account; use the link below. \n\n
        http://vweb-tealninja.rhcloud.com//activate.php?email=" .
        $register_data['email'] .
        "&email_code=" .
        $register_data['email_code'] .
        "\n\n - JT");
    $db = null;
}

function user_count(){
    return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `user` WHERE `active` = 1"),0);
}

function user_data($user_id){
    $data = array();
    $user_id = (int)$user_id;
    
    $func_num_args = func_num_args();
    $func_get_args = func_get_args();
    
    if($func_num_args > 1){
        unset($func_get_args[0]);
        $fields = '`' . implode('`,`', $func_get_args) . '`';
        global $db;
        $stmt = $db->prepare("SELECT $fields FROM user WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

}

function logged_in() {
    return (isset($_SESSION ['user_id'])) ? true : false;
}

function user_exists($username){
    $username = sanitize($username);//changed to PDO -- do i need to sanitize?
    global $db;
    $stmt = $db->prepare("SELECT COUNT(user_id) FROM user WHERE username = :username");
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch();
    return ((($result['COUNT(user_id)']) >= 1) ? true : false);
    $db = null;
}

function email_exists($email){ //do i need to sanitize?
    global $db;
    $stmt = $db->prepare("SELECT COUNT(user_id) FROM user WHERE email = :email");
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();
    return ($result['COUNT(user_id)'] >=1) ? true:false;
    $db = null;

}

function user_active($username){
    $username = sanitize($username); // is this necessary?
    global $db;
    $stmt = $db->prepare("SELECT COUNT(user_id) FROM user WHERE username = :username  AND active = 1");
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();
    return ($result['COUNT(user_id)'] >=1) ? true:false;
    $db = null;
}

function user_id_from_username($username){
    $username = sanitize($username);
    global $db;
    $stmt = $db->prepare("SELECT user_id FROM user WHERE username = :username");
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();
    return ($result['user_id']);
    $db = null;
}


function user_id_from_email($email){
    $email = sanitize($email);
    return mysql_result(mysql_query("SELECT `user_id` FROM `user` WHERE `email` = '$email'"),0,'user_id');
}

function login($username, $password){
    $user_id = user_id_from_username($username);

    //sanitize username and encrypt password
    //$username = sanitize($username);
    $password = md5($password);
    global $db;
    $stmt = $db->prepare("SELECT COUNT(user_id) FROM user WHERE username = :username AND password = :password");
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->bindValue(":password", $password, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();
    return ($result['COUNT(user_id)'] >=1) ? $user_id:false;
    $db = null;
    
}

?>
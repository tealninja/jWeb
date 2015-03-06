<?php 


//sends an email
function email($to, $subject, $body) {
    //mail($to, $subject, $body, 'From: Hello@mywebsite.org');
    mail('teal.john@gmail.com', 'new user!', 'someone signed up', 'From: teal.john@gmail.com');

}

function logged_in_redirect(){
    if (logged_in() === true){
        header('Location: index.php');
    }
}

function protect_page(){
    if (logged_in() === false){
        header('Location: protected.php');
        exit();
    }
}


function admin_protect(){
    global $user_data;
    if (has_access($user_data['user_id'],1) === false){
        header('Location: index.php');
    }

}
function array_sanitize(&$item) {
    $item = htmlentities(strip_tags(mysql_real_escape_string($item)));
}

function sanitize($data){
    return htmlentities(strip_tags(mysql_real_escape_string($data)));
}

function output_errors($errors){
    $output= array();
    foreach($errors as $error){
        $output[] = '<li>' . $error . '</li>';
    } 
    return '<ul>' . implode('',$output) . '</ul>';
}
?>
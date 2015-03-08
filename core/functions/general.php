<?php 


//sends an email
function email($to, $subject, $body) {
    //sends email using mailgun; see https://blog.openshift.com/email-in-the-cloud-with-mailgun/
    //mail($to, $subject, $body, 'From: Hello@mywebsite.org');
    //mail('teal.john@gmail.com', 'new user!', 'someone signed up', 'From: teal.john@gmail.com');
    $api_key = 'key-9c6b17aa0ea761f75753b6d202616265';//key from mailgun
    $domain = 'https://api.mailgun.net/v2/' . 'sandbox1190eeea19d443a19cbeb3e1163268ab.mailgun.org';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $api_key);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL,$domain); //update with my domain
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        array(  'from'      =>'John Teal <teal.john@gmail.com>',
                'to'        =>  $to,
                'subject'   => $subject,
                'text'      => $body));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
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
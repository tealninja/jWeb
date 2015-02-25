<?php 
include 'core/init.php';
logged_in_redirect();
if (empty($_POST) === false) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    
    if(empty($username) === true || empty($password) === true){
        $errors[] = 'you need to enter a username and password';
        
    } else if(user_exists($username) === false){
        $errors[] = 'username not available';            
    
    } else if(user_active($username) === false){
        $errors[] = 'accounts not activated';
        //do something to allow users to active the account
    }else{
        $login = login($username, $password);
        if ($login == false){
            $errors[] = 'the username and password combination is incorrect';
        }else{
            //set the user session -- the user has logged in
            $_SESSION['user_id'] = $login;
            header('Location: index.php');
            exit();
            //redirect the user to home
        }
    }
    //print_r($errors);
}else{
    $errors[] = 'no data recieved';
}
include 'includes/overall/header.php';

if (empty($errors) === false) {
?>

    <h2>Tried to log you in but...</h2>
<?php
}
echo output_errors($errors);

include 'overall/footer.php';
?>
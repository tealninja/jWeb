<?php 
include "core/init.php";
logged_in_redirect();
include "includes/overall/header.php"; 
include 'includes/header.php';
include 'includes/leftnav.php';
include 'includes/content.php';
//check if form has been submitted
if (empty($_POST) ===false){
    $required_fields = array('username','password','password_again','first_name','email');
    foreach($_POST as $key=>$value) {
        if (empty($value)  && in_array($key, $required_fields) ===true) {
            $errors[] = 'Fields marked with an asterisk are required';
            break 1;
        }
    }
    //check if users exists (do with ajax?)
    if (empty($errors) === true) {
        if(user_exists($_POST['username']) === true) {
            $errors[] = 'sorry, the username \'' . $_POST['username'] . '\' is already taken'; 
        }
        if (preg_match("/\\s/",$_POST['username']) ==true){
            $errors[]= 'Your username must not contain any spaces';
        }
        if (strlen($_POST['password']) <6){
            $errors[] = 'Your password must be at least 6 characters long]';
        }
        if (($_POST['password']) !=$_POST['password_again']){
            $errors[] = 'Your passwords do not match]';
        }
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false){
            //just checks to see if the email format is OK
            $errors[] = 'A valid email address if required';
        }
        if (email_exists($_POST['email']) === true){
            $errors[] = 'sorry the email is already in use';
        }
    }
}
?>

<h1>Register</h1>

<?php 

if (isset($_GET['success']) && empty($_GET['success'])){
    echo 'you\'ve registered successfully. Check your email to activate your account.';
} else {
    if(empty($_POST)=== false && empty($errors) === true){
        //register user
        $register_data = array(
            'username'      => $_POST['username'],
            'password'      => $_POST['password'],
            'first_name'    => $_POST['first_name'],
            'last_name'     => $_POST['last_name'],
            'email'         => $_POST['email'],
            'email_code'    => md5($_POST['username']+microtime()),

        );
        register_user($register_data);
        header('Location: register.php?success');
        exit();
    } else if (empty($errors) === false) {
        echo output_errors($errors);
    }

?>

    <form action="" method="post">
        <ul>
            <li>
                Username*:<br>
                <input type="text" name="username">
            </li>
            <li>
                Password*:<br>
                <input type="password" name="password">
            </li>
            <li>
                Confirm Password*:<br>
                <input type="password" name="password_again">
            </li>
            <li>
                First Name*:<br>
                <input type="text" name="first_name">
            </li>
            <li>
                Last Name*:<br>
                <input type="text" name="last_name">
            </li>
            <li>
                Email* <br>
                <input type="text" name = "email">
            </li>
            <li> </br>
                <input type="submit" value="Register">
            </li>
        </ul>

    </form>
<?php 
}
include 'includes/footer.php';
include "includes/overall/footer.php"; ?>
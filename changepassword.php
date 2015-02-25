<?php   include 'core/init.php';
protect_page();

include 'includes/overall/header.php';
include 'includes/header.php';
include 'includes/leftnav.php';
include 'includes/content.php';


if (empty($_POST) === false) {
    $required_fields = array('current_password', 'password', 'password_again');
    foreach($_POST as $key=>$value) {
        if (empty($value) && in_array($key, $required_fields) === true) {
            $errors[] = 'Fields marked with an astrisk are requried';
            break 1;
        }
    
    }
    
    if (md5($_POST['current_password']) === $user_data['password']) {
        //check if the two new password match and fit criteria
        if (trim($_POST['password']) !== trim($_POST['password_again'])){
            $error[] = 'Your new passwords od  not match';
        } else if (strlen($_POST['password']) < 6) {
            $errors[] = 'Your password must be at least 6 characters';
        }
    } else {
        $errors[] = 'Your current password is incorrect';
    
    }
}


include "includes/overall/header.php"; ?>
<h1>Change Password</h1>
<?php 

if (isset($_GET['success']) === true && empty($_GET['success'])) {
    echo 'Your password has been  changed';
} else {
    if(isset($_GET['force']) === true && empty($_GET['force'])){
        
    ?>
    <p>You must change your password</p>
    <?php
    }
    if (empty($_POST) === false && empty($errors) ===true){ 
        //we have posted the form and no errors -- change the password
        change_password($session_user_id, $_POST['password']);
        header('Location: changepassword.php?success');

    } else if (empty($errors) === false){
        //output errors
        echo output_errors($errors); 

    }

    ?>
    <form action="" method="post">
        <ul>
            <li>
                Current password*:</br>
                <input type="password" name="current_password">
            </li>
            <li>
                New password*:</br>
                <input type="password" name="password">
            </li>

            <li>
                New password again*:</br>
                <input type="password" name="password_again">
            </li>
            <li></br>
                <input type="submit" value="Change password">
            </li>

        </ul>


    </form>

<?php 
}
include 'includes/footer.php';
include 'includes/overall/footer.php';
?>
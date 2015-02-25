<?php   include 'core/init.php';

protect_page();
include "includes/overall/header.php";
include 'includes/header.php';
include 'includes/leftnav.php';
include 'includes/content.php';

if (empty($_POST) === false) {
    $required_fields = array('first_name','email');
    foreach($_POST as $key=>$value) {
        if (empty($value)  && in_array($key, $required_fields) ===true) {
            $errors[] = 'Fields marked with an asterisk are required';
            break 1;
        }
    }
    
    if(empty($errors) === true) {
        //validate the data -->only have to check email
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'A valid email address is requried';
            
        } else if(email_exists($_POST['email']) && $user_data['email'] !== $_POST['email']) {
            $errors[] = 'Sorry that email already exists';
        }
    }
}

?>

<h2>Settings</h2>
<?php 

if (isset($_GET['success']) === true && empty($_GET['success']) === true){
    echo 'Your information has been updated';
} else {

    if (empty($_POST) === false && empty($errors) === true) {
        //update the information in the database
        
        $allow_email = ($_POST['allow_email'] == 'on') ? 1 : 0;
        
        $update_data = array(
            'first_name'    => $_POST['first_name'],
            'last_name'     => $_POST['last_name'],
            'email'         => $_POST['email'],
            'allow_email'   => $allow_email
        );
        update_user($session_user_id, $update_data);
        header('Location: settings.php?success');

    } else if (empty($errors) === false) {
        output_errors($errors);
    }
    
    ?>

    <form action ="" method="post">
        <ul>
            <li>
                First name:<br>
                <input  type="text" name="first_name" value="<?php echo $user_data['first_name']?>">
            </li>
            <li>
                Last name:<br>
                <input  type="text" name="last_name" value="<?php echo $user_data['last_name']?>">
            </li>
            <li>
                Email:<br>
                <input  type="text" name="email" value="<?php echo $user_data['email']?>">
            </li>
            <li>
                <input type="checkbox" name="allow_email" <?php if($user_data['allow_email'] == 1){echo 'checked="checked"';}?>>Would you like to recieve emails from us?
            </li>
            <li>
                <input type="submit" value="Update">
            </li>
        </ul>

    </form>

    <?php
    }
include 'includes/footer.php';
include "includes/overall/footer.php"; 
?>
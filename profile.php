<?php   
include 'core/init.php';
include "includes/overall/header.php";
include 'includes/header.php';
include 'includes/content.php';

if (isset($_GET['username']) === true && empty($_GET['username']) === false ) {
    $username = $_GET['username'];
    if (user_exists($username))
    {
        $user_id        = user_id_from_username($username);
        $profile_data    = user_data($user_id, 'first_name','last_name', 'email');
        
        ?>
        <h1><?php echo $profile_data['first_name']; ?>'s profile</h1>
        <p>email:<?php echo $profile_data['email']?></p>
        <?php
    } else {
        echo 'user does not exists'; // consider using error reportign to tidy up
    }
} else {
    header('Location: index.php');
}
include 'includes/footer.php';
include 'includes/overall/footer.php';
 
?>

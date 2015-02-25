<?php
include 'core/init.php';

if (logged_in() === false){
    header("Location: index.php");
}

include 'includes/overall/header.php';
include 'includes/header.php';
include 'includes/leftnav.php';
include 'includes/content.php';

?>
<h1>Upload</h1>
<p>
This the upload page!
</p>
<p>
All data should be updloaded in csv format.
</p>
<h2>upload photo</h2>
<?php 

if (isset($_FILES['profile']) === true) {
    if (empty($_FILES['profile']['name']) === true) {
        echo 'Please choose a file';
    } else {
        $allowed = array('jpg', 'jpeg', 'gif', 'png');

        $file_name = $_FILES['profile']['name'];
        $file_extn = strtolower(end(explode('.', $file_name))); 
        $file_temp = $_FILES['profile']['tmp_name'];

        if (in_array($file_extn, $allowed) === true){
            //upload the file
            change_profile_image($session_user_id, $file_temp, $file_extn);
            header('Location:' . $current_file);
        } else {
            echo 'Incorrect file type. Allowed:';
            echo implode(', ', $allowed);
        }
            //does nothign to check file size
    }
}

if (isset($_FILES['data']) === true) {
    if (empty($_FILES['data']) === true) {
        echo 'Please choose a file';
    
    }else {
        $allowed = array('csv');
        $file_name = $_FILES['data']['name'];
        $file_extn = strtolower(end(explode('.', $file_name)));
        $file_temp = $_FILES['data']['tmp_name'];
        
        if (in_array($file_extn, $allowed) === true) {
            upload_csv_file($session_user_id, $file_temp, $file_extn);
            //header...
        } else {
            echo 'Incorrect file type chosen';
            echo implode(',', $allowed);
        }
    }


}

if (empty($user_data['profile']) === false) {
    echo '<img src="', $user_data['profile'], '" alt="', $user_data['first_name'], '\'s Profile Image">';
        }
        
?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="profile"><input type="submit">
    </form>
        
<h2>Upload data</h2>
<form action="" method="post" enctype="multipart/form-data">    
    <input type="file" name="data"><input type="submit">
</form>
<?php

include 'includes/footer.php';
include 'includes/overall/footer.php';

?>

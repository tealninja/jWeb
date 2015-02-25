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
}


include "includes/overall/header.php"; ?>
<h1>Audio Submission</h1>
<?php 

if (isset($_GET['success']) === true && empty($_GET['success'])) {
    echo 'Your data has been submitted';
    ?>
    </br>
    <a href="quickequipmentreport.php">Submit another report</a>

    <?php
} else {
    if(isset($_GET['force']) === true && empty($_GET['force'])){
        
    ?>
    <p>You must change enter data</p>
    <?php
    }
    if (empty($_POST) === false && empty($errors) ===true){ 
        //we have posted the form and no errors -- add the data to an sql database
        $report_data = array(
            'patient_id'        => $_POST['patient_id'],
            'patient_condition' => $_POST['patient_condition'],    
            'datetime'          => $_POST['datetime'],
            
                );
    submit_quick_report($session_user_id, $report_data);

        
        header('Location: quickequipmentreport.php?success'); //add $_GET['sucess'] and redirect
    } else if (empty($errors) === false){
        //output errors
        echo output_errors($errors); 
    }

    ?>
<form action="" method="post">
    <h2>Audio Info</h2>
    <ul>    
        <li>
            Enter the image info</br>
            <input type="file" accept="image/*" capture name="sample_image">
        </li>
        <li>
            Enter the audio info</br>
            <input type="file" accept="audio/*" capture name="sample_image">
        </li>
    <input type="submit" value="Submit">
    </ul>
</form>

<?php 
}
include 'includes/footer.php';
include 'includes/overall/footer.php';
?>
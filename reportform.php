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
<h1>Report Form</h1>
<?php 

if (isset($_GET['success']) === true && empty($_GET['success'])) {
    echo 'Your data has been submitted';
} else {
    if(isset($_GET['force']) === true && empty($_GET['force'])){
        
    ?>
    <p>You must change enter data</p>
    <?php
    }
    if (empty($_POST) === false && empty($errors) ===true){ 
        //we have posted the form and no errors -- add the data to an sql database
        //add_user_report($session_user_id, $_POST['password']);
        header('Location: reportform.php?success'); //add $_GET['sucess'] and redirect
    } else if (empty($errors) === false){
        //output errors
        echo output_errors($errors); 
    }

    ?>
    <form action="" method="post">
        <h2>Patient Info</h2>
        <ul>    
            <li>
                Enter the patient's name </br>
                <input type="text" name="patient_id">
            </li>
        </ul>
        <h2>Descrip the symptoms / observations of the event</h2>
        <h2>Patient</h2>
        <ul>Check all that apply
            <li>
                <input type="checkbox" name="dizzy">dizzy
            </li>
        </ul> 
        

        <h3>Controller</h3>
        <ul>
            <li>
                Serial number. Enter only the digits after XXX </br>
                <input type="number" name="controller_sn">
            </li>
            Check all that are true
            <li>
                <input type="checkbox" name="low_bat">low battery light on </br>
            </li>
            <li>
                <input type="checkbox" name="pump_stop">pump stop light on </br>
            </li>
            <li>
                <input type="checkbox" name="low_speed">low speed light on </br>
            </li>
            <li>
                <input type="checkbox" name="alarm_constant">alarm sounding constant </br>
            </li>
            <li>
                <input type="checkbox" name="alarm_intermittent">alarm sounding intermittent </br>
            </li>
            <li>
                wattmeter reading </br>
                <input type="number" name="wattmeter_reading">
            </li>
            <li>
                date and time event recorded </br>
                <input type="datetime" name="date_and_time">
            </li>
        </ul>
    <h3>Battery</h3>
        <ul>
            <li>
                Serial number. Enter only the digits after XXX </br>
                <input type="number" name="battery_sn">
            </li>
            <li>
                Number of LEDs on the battery </br>
                <input type="number" name="number of LEDs on battery">
            </li>
        </ul>
        
    <input type="submit" value="Change password">
    </form>

<?php 
}
include 'includes/footer.php';
include 'includes/overall/footer.php';
?>
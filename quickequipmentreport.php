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
<h1>Equipment Report Form</h1>
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
            
            //equipment info
            'controller'        => $_POST['controller'],
            'battery'           => $_POST['battery'],
            'battery2'          => $_POST['battery2'],
            'extension_cable'   => $_POST['extension_cable'],
            'y_cable'           => $_POST['y_cable'],
            'battery_cable'     => $_POST['battery_cable'],
            'battery_cable2'    => $_POST['battery_cable2'],

            //event info
            'low_batt'          => $_POST['low_batt'],
            'pump_stop'         => $_POST['pump_stop'],
            'low_speed'         => $_POST['low_speed'],
            'alarm_constant'    => $_POST['alarm_constant'],
            'alarm_intermittent'=> $_POST['alarm_intermittent'],
            'wattmeter'         => $_POST['wattmeter'],
            
            //battery info
            'leds'              => $_POST['leds'],
            'leds2'             => $_POST['leds2'],
            'notes'             => $_POST['notes'],
        );
    submit_quick_report($session_user_id, $report_data);

        
        header('Location: quickequipmentreport.php?success'); //add $_GET['sucess'] and redirect
    } else if (empty($errors) === false){
        //output errors
        echo output_errors($errors); 
    }

    ?>
<form action="" method="post">
    <h2>Patient Info</h2>
    <ul>    
        <li>
            Enter the patient's ID. Do <strong>not</strong> enter the patient's name</br>
            <input type="text" name="patient_id">
        </li>
        <li>Patient Condition
            <select name="patient_condition">
                <option value="no_change">No change</option>
                <option value="discomfort"> Discomfort</option>
                <option value="hospitalization">Hospitalization</option>
                <option value="critical">Critical</option>
                <option value="deceased">Deceased</option>
            </select>
        </li>
        <li>            
            Enter any additional notes about the patient condition or the event. </br>
            <input type="text" name="notes" class="large_text_field">
        </li>
    </ul>
    <h2>Equipment Info</h2>
    <ul>
        <li>
            <strong>Controller</strong> serial number </br>
            <input type="text" name="controller">
        </li>
        <li>
            <strong>Battery</strong> serial number</br>
            <input type="text" name="battery">
        </li>
        <li>
            <strong>Secondard battery</strong> serial number (if available))</br>
            <input type="text" name="battery2">
        </li>
        <li>
            <li>
            <strong>Extension Cable</strong> serial number</br>
            <input type="text" name="extension_cable">
        </li>
        <li>
            <strong>Y Cable</strong> serial number</br>
            <input type="text" name="y_cable">
        </li>
            <li>
            <strong>Battery Cable</strong> serial number</br>
            <input type="text" name="battery_cable">
        </li>
        <li>
            Secondary Battery cable serial number (if available)</br>
            <input type="text" name="battery_cable2">
        </li>
    </ul>
    <h2>Event Observations</h2>
    Date and time event recorded </br>
    <input type="datetime-local" name="datetime">
    <h3>Controller</h3>
    <ul>   
        Check all that are true
        <li>
            <input type="checkbox" name="low_batt" value="1">Low battery light on
        </li>
        <li>
            <input type="checkbox" name="pump_stop" value="1">Pump stop light on
        </li>
        <li>
            <input type="checkbox" name="low_speed" value="1">Low speed light on
        </li>
        <li>
            <input type="checkbox" name="alarm_constant" value="1">Alarm sounding constant
        </li>
        <li>
            <input type="checkbox" name="alarm_intermittent" value="1">Alarm sounding intermittent
        </li>
        <li>
            Wattmeter reading (enter the avearage, if the wattmeter is pulsing) </br>
            <input type="number" name="wattmeter" min="3" max="13" >
        </li>
        
    </ul>
    <h3>Battery Charge Level (primary)</h3>
    <input type="radio" name="leds" value="0" >0
    <input type="radio" name="leds" value="1" >1 
    <input type="radio" name="leds" value="2" >2
    <input type="radio" name="leds" value="3" >3 
    <input type="radio" name="leds" value="4" >4
    <input type="radio" name="leds" value="5" >5
    </br>
    <input type="radio" name="leds" values="-1" checked>unknown

    <h3>Battery Charge Level (secondary)</h3>
    <input type="radio" name="leds2" value="0" >0
    <input type="radio" name="leds2" value="1" >1 
    <input type="radio" name="leds2" value="2" >2
    <input type="radio" name="leds2" value="3" >3 
    <input type="radio" name="leds2" value="4" >4
    <input type="radio" name="leds2" value="5" >5
    </br>
    <input type="radio" name="leds2" values="-1" checked>unknown
    </br>
    <input type="submit" value="Submit Data">
</form>

<?php 
}
include 'includes/footer.php';
include 'includes/overall/footer.php';
?>
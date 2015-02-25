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
<h1>Patient Report Form</h1>
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

        
        header('Location: patientreport.php?success'); //add $_GET['sucess'] and redirect
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
    Date and time event recorded </br>
    <input type="datetime-local" name="datetime">
</form>
<iframe src='http://cdn.knightlab.com/libs/timeline/latest/embed/index.html?source=0Agl_Dv6iEbDadHdKcHlHcTB5bzhvbF9iTWwyMmJHdkE&font=Bevan-PotanoSans&maptype=toner&lang=en&height=650' width='100%' height='650' frameborder='0'></iframe>
<?php 
}
include 'includes/footer.php';
include 'includes/overall/footer.php';
?>
    <!--leftnav-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="Overview.php">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="index.php">Reports</a></li>
            <li><a href="index.php">Analytics</a></li>
            <li><a href="index.php">Export</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li class="active"><a href="">Submit Reports</a></li>  
            <li>
                <a href="quickequipmentreport.php">Quick Equipment Report</a>
            </li>
            <li>
                <a href="quickpatientreport.php">Quick Patient Report</a>
            </li>
            <li>
                <a href="audiosubmission.php">Audio Submission</a>    
            </li>  
          </ul>
          <ul class="nav nav-sidebar">
            <li class="active"><a href="searchreports.php">Search reports</a></li>  
            <li><a href="">(sub search)</a></li>
            <li><a href="">(sub search)</a></li>
            
            <?php  if(logged_in() === true){echo '<li><a href="upload.php">Uploads</a></li>';} ?>
          </ul>
        </div>

<!--header / top menu-->
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">vWeb</a>
        </div>
        <?php 
        if(logged_in() === false) {
            include 'includes/widgets/login.php';
        } else {
            include 'includes/widgets/loggedin.php';
        }
          ?>
      </div>
    </nav>

<?php

require_once 'database/topfile.php';

?>
<!DOCTYPE HTML>
<html>

<head>
<meta charset="utf-8">
<title>OneplaceSMS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="shortcut icon" href="ico.png">

<!-- Stylesheets -->
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/owl.theme.css">
<link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.4.custom.min.css">
<link rel="stylesheet" href="rs-plugin/css/settings.css">
<link rel="stylesheet" href="css/theme.css">
<link rel="stylesheet" href="css/colors/turquoise.css" id="switch_style">
<link rel="stylesheet" href="css/responsive.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600,700">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<!-- Javascripts --> 
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script> 
<script type="text/javascript" src="js/bootstrap.min.js"></script> 
<script type="text/javascript" src="js/bootstrap-hover-dropdown.min.js"></script> 
<script type="text/javascript" src="js/jquery.nicescroll.js"></script>  
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script> 
<script type="text/javascript" src="js/jquery.forms.js"></script><script type="text/javascript" src="js/parallax.min.js"></script><script type="text/javascript" src="js/parallax.min.js"></script> 
<script type="text/javascript" src="js/switch.js"></script> 
<script type="text/javascript" src="js/custom.js"></script> 
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../www.google-analytics.com/analytics.js','ga');

  //ga('create', 'UA-50960990-1', 'slashdown.nl');
  //ga('send', 'pageview');
</script>
</head>

<body>

<!-- Header -->
<header>
  <!-- Navigation -->
  <div class="navbar yamm navbar-default" id="sticky">
    <div class="container">
      <div class="navbar-header">
        <button type="button" data-toggle="collapse" data-target="#navbar-collapse-grid" class="navbar-toggle"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a href="index.php" class="navbar-brand">         
        <!-- Logo -->
        <div id="logo"> <img id="default-logo" src="images/logo-2.png" alt="Starhotel" style="height:44px;"> </div>
        </a> </div>
      <div id="navbar-collapse-grid" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">

          <li class="index.php"> <a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li > <a href="all-contacts.php"><i class="fa fa-book"></i> Contacts</a></li>

		      <li > <a href="all-groups.php"><i class="fa fa-groups"></i> Groups</a></li>
          
          <li> <a href="message-logs.php"><i class="fa fa-file-text-o"></i> Message Logs</a></li>

          <?php if($level==1){ ?>

          <li class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle js-activated"><i class="fa fa-cogs"></i> Settings<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="manage-users.php">Manage Users</a></li>
              <li><a href="system-settings.php">System Settings</a></li>
              <li><a href="sms-settings.php">SMS Settings</a></li>
              <li><a href="admin-settings.php">Admin Settings</a></li>
              <li><a href="mail-settings.php">Mail Settings</a></li>
            </ul>
          </li>

          <?php }else{ ?> 

          <li class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle js-activated"><i class="fa fa-cogs"></i> Settings<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="admin-settings.php">Profile Settings</a></li>
            </ul>
          </li>

          <?php } ?>

          <li> <a href="logout" style="color:brown;"><i class="fa fa-sign-out"></i> Logout</a></li>

        </ul>
      </div>
    </div>
  </div>
</header>


<script type="text/javascript">$(document).ready(function(){$('#parallax-pagetitle').parallax("50%", -0.55);});</script>

<div class="container">
  <div class="row"> 

    <section class="room-slider standard-slider mt50">
      <div class="col-sm-12 col-md-8">

        <div class="col-md-8">
            <div class="form-group">
                <label for="text" accesskey="E">Africastalking Username</label>
                <input type="email" id="as_user" value="<?php echo $as_username; ?>" class="form-control" value="Africastalking Username" />
            </div>
            <div class="form-group">
                <label for="text" accesskey="E">Africastalking API Key</label>
                <input type="text" id="as_key" value="<?php echo $as_key; ?>" class="form-control" value="Africastalking API Key" />
            </div>
            <div class="form-group">
                <label for="text" accesskey="E">Africastalking Sender ID (Default:SMSLEOPARD)</label>
                <input type="text" id="as_senderid" value="<?php echo $as_sender_id; ?>" class="form-control" value="Africastalking Sender ID" />
            </div>
            <div class="form-group">
                <label for="text" accesskey="E">Low Credit Alert Value</label>
                <input type="text" id="asalertvalue" value="<?php echo $setminimum; ?>" class="form-control" value="Low Credit Alert Value" />
            </div>
            <p id="smsresponse"></p>
            <button type="button" id="smsclick" class="btn btn-default">Save Changes</button>
        </div>
        
            
      </div>
    </section>
    
    <!-- side -->
    <?php include_once 'side.php'; ?>
    
  </div>
</div>



<!-- Footer -->
<footer>
 
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-xs-6"> &copy; 2015 Oneplace Technologies LTD All Rights Reserved </div>
      </div>
    </div>
  </div>
</footer>

<!-- Go-top Button -->
<div id="go-top"><i class="fa fa-angle-up fa-2x"></i></div>

</body>

</html>
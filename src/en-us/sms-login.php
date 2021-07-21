<?php

session_start();

if(isset($_SESSION['sandbox'])){
  header('location:two-factor-login.php');
}
if(isset($_SESSION['bulkadmin'])){
  header('location:index.php');
}

?>

<!DOCTYPE HTML>
<html>

<!-- Mirrored from www.slashdown.net/starhotel-html/room-detail.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Nov 2015 18:47:14 GMT -->
<head>
<meta charset="utf-8">
<title>Login | Oneplace SMS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="shortcut icon" href="ico.png">

<!-- Stylesheets -->
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/owl.theme.css">
<link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.4.custom.min.css">
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
</head>

<body style="background-color:#00ccff;">

<!-- Parallax Effect -->
<script type="text/javascript">$(document).ready(function(){$('#parallax-pagetitle').parallax("50%", -0.55);});</script>

<div class="container">
  <div class="row"> 
    <!-- Slider -->
    <section class="room-slider standard-slider mt50">
      <div class="col-sm-12 col-md-6">
        <div id="owl-standard" class="owl-carousel">
          <div class="item"> <a href="images/smile.jpg" data-rel="prettyPhoto[gallery1]"><img src="images/smile.jpg" alt="OneplaceSMS" class="img-responsive"></a> </div>
        </div>
      </div>
    </section>
    
    <!-- Reservation form -->
    <section id="reservation-form" class="mt50 clearfix">
      <div class="col-sm-12 col-md-3">

        <form class="reservation-vertical clearfix" role="form" name="reservationform" id="reservationform">
          <h4 class="">Login</h4>

          <div id="loginmessage"></div>
          <!-- Error message display -->
          <div class="form-group">
            <label for="loginusername" accesskey="E">Username</label>
            <input name="username" type="text" id="loginusername" value="" class="form-control" placeholder="Username"/>
          </div>

          <div class="form-group">
            <label for="loginpassword" accesskey="E">Password</label>
            <input name="password" type="password" id="loginpassword" value="" class="form-control" placeholder="Password"/>
          </div>

          <button id="loginbutton" class="btn btn-primary btn-block">Login</button>
          <br>

          <a href="sms-forgot-password.php">Forgot Password?</a>

        </form>

      </div>
    </section>

  </div>
</div>


<!-- Go-top Button -->
<div id="go-top"><i class="fa fa-angle-up fa-2x"></i></div>

</body>

<!-- Mirrored from www.slashdown.net/starhotel-html/room-detail.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Nov 2015 18:47:16 GMT -->
</html>
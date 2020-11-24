<?php

session_start();
/**
* Get all user data into database and possibly send a text
* Order data receiver
*/
class User
{
	private $uemail, $uusername, $uphone, $upassword, $uopenmessage, $ugroupmessage, $ubroadcast,$uviewlogs,$uaddcontact,$uaddgroup,$uremovecg,$uviewcredits;

	
	function __construct()
	{
		require_once 'topfile.php';
		require_once('AfricasTalkingGateway.php');

		if(isset($_REQUEST['uemail']) && 
			isset($_REQUEST['uusername']) && 
			isset($_REQUEST['uphone']) && 
			isset($_REQUEST['upassword']) && 
			isset($_REQUEST['uopenmessage']) && 
			isset($_REQUEST['ugroupmessage']) && 
			isset($_REQUEST['ubroadcast']) && 
			isset($_REQUEST['uviewlogs']) && 
			isset($_REQUEST['uaddcontact']) && 
			isset($_REQUEST['uaddgroup']) && 
			isset($_REQUEST['uremovecg']) && 
			isset($_REQUEST['uviewcredits']))
		{
			$this->uemail            =   $_REQUEST['uemail'];
			$this->uusername         =   $_REQUEST['uusername'];
			$this->uphone     		 =   $_REQUEST['uphone'];
			$this->upassword         =   $_REQUEST['upassword'];
			$this->uopenmessage      =   $_REQUEST['uopenmessage'];
			$this->ugroupmessage     =   $_REQUEST['ugroupmessage'];
			$this->ubroadcast        =   $_REQUEST['ubroadcast'];
			$this->uviewlogs         =   $_REQUEST['uviewlogs'];
			$this->uaddcontact       =   $_REQUEST['uaddcontact'];
			$this->uaddgroup         =   $_REQUEST['uaddgroup'];
			$this->uremovecg         =   $_REQUEST['uremovecg'];
			$this->uviewcredits      =   $_REQUEST['uviewcredits'];


			# validations
			if(empty($this->uemail) || 
				empty($this->uusername) || 
				empty($this->uphone) || 
				empty($this->upassword) || 
				empty($this->uopenmessage) || 
				empty($this->ugroupmessage) || 
				empty($this->ubroadcast) || 
				empty($this->uviewlogs) || 
				empty($this->uaddcontact) || 
				empty($this->uaddgroup) || 
				empty($this->uremovecg) || 
				empty($this->uviewcredits))
			{
			  	exit("<h5 style='color:orange'>Please fill all required fields</h5>");
			}

			if (!preg_match("/^[a-zA-Z ]*$/",$this->uusername))
			{
				exit("<h5 style='color:orange'>Username should not contain numbers or special characters</h5>");
			}

			if(strlen($this->uusername) < 6)
			{
				exit("<h5 style='color:orange'>Username should be a minimum of 6 letters</h5>");
			}

			if(strlen($this->upassword) < 8)
			{
				exit("<h5 style='color:orange'>Password should be a minimum of 8 characters</h5>");
			}

			if(! filter_var($this->uemail, FILTER_VALIDATE_EMAIL))
			{
				exit("<h5 style='color:orange'>Please check your email format</h5>");
			}

			#verify email
			$verify_email = $db->query("SELECT * FROM `sms_users` WHERE `email`='$this->uemail'");
			if($verify_email->num_rows > 0)
			{
				exit("<h5 style='color:orange'>The email address you gave is already registered</h5>");
			}

			#verify username
			$verify_username = $db->query("SELECT * FROM `sms_users` WHERE `username`='$this->uusername'");
			if($verify_username->num_rows > 0)
			{
				exit("<h5 style='color:orange'>The username you gave is already in use</h5>");
			}

			$code     = rand(1000,9999);

			# get date today
			$date     = date('d-M-Y H:i:s');
			#encrypt database
			$encpass  = md5($this->upassword);

			# insert into database
			$saveUser         =  "INSERT INTO `sms_users`

			(`email`,`username`,`password`,`date`,`level`,`open_msg`,`group_msg`,`broadcast_msg`,`credit_permit`,`contact_permit`,`group_permit`,`view_logs`,`remove_group_contact`,`login_pass`,`phone`,`log_permit`)

			VALUES('$this->uemail','$this->uusername','$encpass','$date','2','$this->uopenmessage','$this->ugroupmessage','$this->ubroadcast','$this->uviewcredits','$this->uaddcontact','$this->uaddgroup','$this->uviewlogs','$this->uremovecg','$code','$this->uphone','2')";

			if($saveUser_run   =  $db->query($saveUser))
			{
			    echo "<h5 style='color:green;'><i class='fa fa-check-square'></i> User added</h5>";
			}
		}

		
	}
	
}

# new order
$order = new User();

?>

<?php

/**
* written by Kanyi for Oneplace Technologies
* written in the simplest form to allow nerds to understand
* Distributed as open source http://oneplacesms.com/terms
* 
* 
* This file creates and writes the actual config file 
*/
class WriteFile
{
	private $host,$username,$password,$database;

	function __construct()
	{
		if(isset($_REQUEST['host']) && isset($_REQUEST['username']) && isset($_REQUEST['password']) && isset($_REQUEST['database']))
		{
			
			# sanitize REQUEST variables
			$this->host       =  $_REQUEST['host'];
			$this->username   =  $_REQUEST['username'];
			$this->password   =  $_REQUEST['password'];
			$this->database   =  $_REQUEST['database'];


			# make sure important fields are not empty

			if(empty($this->host) || empty($this->username) || empty($this->database))
			{
				exit("<h5 style='color:orange'>Please fill all required fields</h5>");
			}

			# test server connection

			if($db = new mysqli($this->host,$this->username,$this->password,$this->database))
			{
				# test database selection

				if($db->connect_errno == 0)
				{

					# Write config file

					$myfile = fopen("../../en-us/database/config.php", "w");

					if($myfile)
					{

					$txt = "
<?php\n
	# Simple Connection File\n

	# PROUDLY POWERED BY ONEPLACE TECHNOLOGIES LTD\n
	/**
	* written by Kanyi for Oneplace Technologies
	* Improvements by Samuel<samuel@samuelmwangi.co.ke>
	* written in the simplest form to allow nerds to understand
	* Distributed as open source http://oneplacesms.com/terms
	* 
	* 
	* This file is actually the login file
	* This file can be edited inline anytime your server credentials change
	*/
	
	##################CONNECT TO SERVER####################################################
	\$db = new mysqli('".$this->host."','".$this->username."','".$this->password."','".$this->database."') or die('Cannot connect');\n

	##################TEST CONNECTION#################################################

	if(\$db->connect_errno > 0){
		die('Unable to connect to database [' . \$db->connect_error . ']');
	}

	/**
	* This code has been made as simple as possible
	* You can do your own manipulation to enable OOP login procedure
	* http://oneplacesms.com/terms
	* 
	* 
	*/
	
//The PHP Closing tag not necessary."; 
						$write_config_file = fwrite($myfile, $txt);
											 fclose($myfile);
						if ($write_config_file) {

								#######################################CREATE  TABLES################################################
								$db->query("								
									CREATE TABLE IF NOT EXISTS `sms_users` (
									  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
									  `email` varchar(250) NOT NULL,
									  `username` varchar(20) NOT NULL,
									  `password` varchar(32) NOT NULL,
									  `date` varchar(30) NOT NULL,
									  `level` int(1) NOT NULL,
									  `open_msg` int(1) NOT NULL,
									  `group_msg` int(1) NOT NULL,
									  `broadcast_msg` int(1) NOT NULL,
									  `credit_permit` int(1) NOT NULL,
									  `contact_permit` int(1) NOT NULL,
									  `group_permit` int(1) NOT NULL,
									  `view_logs` int(1) NOT NULL,
									  `remove_group_contact` int(1) NOT NULL,
									  `login_pass` int(5) NOT NULL,
									  `password_token` varchar(255) NULL,
									  `token_expiry`  int NULL,
									  `phone` varchar(20) NOT NULL,
									  `log_permit` int(1) NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1;
								");
								#############################################################################################################
								#######################################CREATE  TABLES################################################
								$db->query("								
									CREATE TABLE IF NOT EXISTS `sms_scheduled_messages` (
										`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
										`message` text NOT NULL,
										`sent_by` varchar(55) NOT NULL,
										`scheduled_time` datetime NOT NULL,
										`date_sent` datetime NOT NULL,
										PRIMARY KEY (`id`)
									) ENGINE=InnoDB DEFAULT CHARSET=latin1;
								");
								#############################################################################################################
								#######################################CREATE  TABLES################################################
								$db->query("								
									CREATE TABLE IF NOT EXISTS `sms_message_recipients` (
										`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
										`message_id` int(10) unsigned NOT NULL,
										`phone_number` varchar(25) NOT NULL,
										`status` varchar(25) NOT NULL,
										PRIMARY KEY (`id`),
										KEY `message_id` (`message_id`)
									) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
								");
								#############################################################################################################

								#######################################CREATE  TABLES################################################
								$db->query("								
									CREATE TABLE IF NOT EXISTS `sms_settings` (
									  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
									  `as_username` varchar(50) NOT NULL,
									  `as_key` varchar(250) NOT NULL,
									  `as_sender_id` varchar(11) NOT NULL,
									  `system_name` varchar(100) NOT NULL,
									  `security_2_factor` int(1) NOT NULL,
									  `minbalance` int(2) NOT NULL,
									  `broadcast_authority` int(1) NULL,
									  `default_country_code` varchar(5) NOT NULL default '+254',
									  `password_reset_type` varchar(10) NOT NULL,
									  `email_protocol` enum('smtp','mail','sendmail','qmail') not null default 'mail',
									  `email_from`	varchar(255) NULL,
									  `email_from_name`	varchar(255) NULL,
									  `email_smtp_host` varchar(255) NULL,
									  `email_smtp_secure` varchar(12) NULL,
									  `email_smtp_port` int NULL,
									  `email_smtp_user` varchar(255),
									  `email_smtp_pass` varchar(255)
									) ENGINE=InnoDB DEFAULT CHARSET=latin1;
								");
								#############################################################################################################
								#######################################CREATE  TABLES####################################################
								$db->query("								
									CREATE TABLE IF NOT EXISTS `sms_logs` (
									  `id` int(12) NOT NULL AUTO_INCREMENT PRIMARY KEY,
									  `sent_to` varchar(30) NOT NULL,
									  `message` text NOT NULL,
									  `date` varchar(30) NOT NULL,
									  `by` varchar(100) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1;
								");
								#############################################################################################################
								#######################################CREATE  TABLES####################################################
								$db->query("								
									CREATE TABLE IF NOT EXISTS `sms_group_members` (
									  `id` int(12) NOT NULL AUTO_INCREMENT PRIMARY KEY,
									  `group` int(12) NOT NULL,
									  `member` int(12) NOT NULL,
									  `added_by` varchar(100) NOT NULL,
									  `date` varchar(30) NOT NULL
									) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;
								");
								#############################################################################################################
								#######################################CREATE  TABLES####################################################
								$db->query("								
									CREATE TABLE IF NOT EXISTS `sms_groups` (
									  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
									  `group_name` varchar(100) NOT NULL,
									  `created_by` varchar(100) NOT NULL,
									  `date` varchar(30) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1;
								");
								#############################################################################################################
								#######################################CREATE  TABLES####################################################
								$db->query("								
									CREATE TABLE IF NOT EXISTS `sms_contacts` (
									  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
									  `contact_name` varchar(250) NOT NULL,
									  `phone_number` varchar(20) NOT NULL,
									  `organization` varchar(100) NOT NULL,
									  `added_by` varchar(100) NOT NULL,
									  `date` varchar(30) NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1;
								");
								#############################################################################################################
								#######################################CREATE  TABLES####################################################
								$db->query("								
									CREATE TABLE IF NOT EXISTS `sms_activity` (
									  `id` int(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,
									  `activity_log` text NOT NULL
									) ENGINE=InnoDB DEFAULT CHARSET=latin1;
								");
								#############################################################################################################

								echo 'success';

						}else{
						echo "<h5 style='color:orange'>Unable to create configs file</h5>";
					}

					}else{
						echo "<h5 style='color:orange'>Unable to create config file</h5>";
					}
					
					
				}else{

					die("<h5 style='color:orange'>Database provided does not exist</h5>");
				}

			}else{

				die("<h5 style='color:orange'>Connection Failed</h5>");
			}

		}
	}
}

$writefile = new WriteFile();

?>

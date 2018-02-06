<?php

class MailSettings{
	public function __construct()
	{
		require_once 'topfile.php';
		require_once 'mail.php';
		
		if(!empty($_POST['email_protocol']) && !empty($_POST['id']))
		{
			$this->email_from 			= $db->real_escape_string($_POST['email_from']);
			$this->email_from_name		= $db->real_escape_string($_POST['email_from_name']);
			$this->email_protocol		= $db->real_escape_string($_POST['email_protocol']);
			$this->email_smtp_host		= $db->real_escape_string($_POST['email_smtp_host']);
			$this->email_smtp_pass		= $db->real_escape_string($_POST['email_smtp_pass']);
			$this->email_smtp_port		= $db->real_escape_string($_POST['email_smtp_port']);
			$this->email_smtp_secure	= $db->real_escape_string($_POST['email_smtp_secure']);
			$this->email_smtp_user		= $db->real_escape_string($_POST['email_smtp_user']);
			$this->id					= $db->real_escape_string($_POST['id']);
			
			error_reporting(-1);
			$TestMail = new Mail();
			
			if($TestMail->test($this))
			{
				
				$sql = "update sms_settings set
							`email_from` = '{$this->email_from}',
							`email_from_name` = '{$this->email_from_name}',
							`email_protocol` = '{$this->email_protocol}',
							`email_smtp_host` = '{$this->email_smtp_host}',
							`email_smtp_pass` = '{$this->email_smtp_pass}',
							`email_smtp_port` = '{$this->email_smtp_port}',
							`email_smtp_secure` = '{$this->email_smtp_secure}',
							`email_smtp_user` = '{$this->email_smtp_user}'
						where id='{$this->id}'";
				
				$db->query($sql);
				$logtext = $_SESSION['bulkadmin']." has updated system email settings on ".date('d-M-Y H:i:s');
				$log = $db->query("INSERT INTO `sms_activity`(`activity_log`)VALUES('$logtext')");
				
				echo '<p style="color:green"><i class="fa fa-check-square"></i> Settings updated</p>';
			}
			else
			{
				echo '<p style="color:orange">The email settings provided are invalid. Check and save again.</p>';
			}
		}
		else
		{
			echo '<p style="color:orange">Please fill all fields</p>';
		}
	}
	
}

$settings = new MailSettings();
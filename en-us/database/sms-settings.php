<?php
/**
* 
*/
class SmsSettings
{
	private $as_user,$as_key,$as_senderid,$asalertvalue;

	function __construct()
	{
		require_once 'topfile.php';

		if(isset($_REQUEST['as_user']) && isset($_REQUEST['as_key']) && isset($_REQUEST['as_senderid']) && isset($_REQUEST['asalertvalue']))
		{
			if($level==1)
			{
				#sanitization
				$this->as_user        =  $db->real_escape_string($_REQUEST['as_user']);
				$this->as_key         =  $db->real_escape_string($_REQUEST['as_key']);
				$this->as_senderid    =  $db->real_escape_string($_REQUEST['as_senderid']);
				$this->asalertvalue   =  $db->real_escape_string($_REQUEST['asalertvalue']);
				#check empty
				if(!empty($this->as_user) && !empty($this->as_key) && !empty($this->as_senderid) && !empty($this->asalertvalue))
				{
					#check against database for record
			$update = $db->query("UPDATE `sms_settings` SET `as_username`='$this->as_user',`as_key`='$this->as_key',`as_sender_id`='$this->as_senderid',`minbalance`='$this->asalertvalue'");
							if($update)
								{
									# Write log
									$logtext = $_SESSION['bulkadmin']." has updated sms settings on ".date('d-M-Y H:i:s');
									$log = $db->query("INSERT INTO `sms_activity`(`activity_log`)VALUES('$logtext')");

									echo '<p style="color:green"><i class="fa fa-check-square"></i> SMS Settings updated</p>';

								}else{
									echo $db->error();
								}
				}else{
					echo '<p style="color:orange">Please fill all fields</p>';
				}
			}else{
					echo '<p style="color:orange">You dont have permission to change settings</p>';
				}
		}
	}
}

$smssettings = new SmsSettings();

?>

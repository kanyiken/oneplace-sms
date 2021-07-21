<?php

require_once 'AfricasTalkingGateway.php';

class GroupMessage
{
	private $gmidentity;
	private $gmmessage;

	function __construct()
	{
		require_once 'topfile.php';

		if(isset($_REQUEST['gmidentity']) && isset($_REQUEST['gmmessage']))
		{
			#sanitization
			$this->gmidentity       =   $db->real_escape_string($_REQUEST['gmidentity']);
			$this->gmmessage        =   $db->real_escape_string($_REQUEST['gmmessage']);
			#check empty
			if(!empty($this->gmidentity) && !empty($this->gmmessage))
			{
				if($group_msg == 1)
				{
					# GET PHONE NUMBERS AND GROUP DATA
					$gd = $db->query("SELECT * FROM `sms_group_members` WHERE `group`='$this->gmidentity'");
						while($userdata = $gd->fetch_array())
						{
							$user_id = $userdata['member'];
							# get phone number
							$user_tbl_check = $db->query("SELECT * FROM `sms_contacts` WHERE `id`='$user_id'");
								$data_nos = $user_tbl_check->fetch_array();
								$listNos .= $data_nos['phone_number'].",";
						}
					$grd = $db->query("SELECT * FROM `sms_groups` WHERE `id`='$this->gmidentity'");
						$group_data = $grd->fetch_array();
							$groupName = $group_data['group_name'];

						# SMS Code	
						$username                      = $as_username;
						$apikey                        = $as_key;
						if($as_sender_id == "")
						{
							$from                      = NULL;
						}else{
							$from                      = $as_sender_id;
						}
						$recipients                    = $listNos;
						$message                       = preg_replace('/\s\s+/', ' ', $this->gmmessage);

						$gateway                       = new AfricasTalkingGateway($username, $apikey);
						try
						{
							$results = $gateway->sendMessage($recipients, $message, $from);
							if($results)
							{
								$date     = date('d-M-Y H:i:s');
								//save record
								$saveRecord = $db->query("INSERT INTO `sms_logs`(`sent_to`,`message`,`date`,`by`)
									                                       VALUES('$groupName','$this->gmmessage','$date','{$_SESSION['bulkadmin']}')");
								if($mybalance < $setminimum)
								{
									$savemin = $db->query("INSERT INTO `sms_activity`(`activity_log`)
									                                        VALUES('lowcredit')");
								}

							}
								if($saveRecord)
								{
									echo '<p style="color:green"><i class="fa fa-check-square"></i> Message sent</p>';
								}
						}
						catch ( AfricasTalkingGatewayException $e )
						{
							echo "Encountered an error while sending: ".$e->getMessage();
						}
				}else{
					echo '<p style="color:orange"><i class="fa fa-lock"></i> Sorry, you do not have permissions to send open messages</p>';
				}
			}else{
					echo '<p style="color:orange">Please provide phone number and message</p>';
			}
		}
	}
}

$groupmessage = new GroupMessage();

?>

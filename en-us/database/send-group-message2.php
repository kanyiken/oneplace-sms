am<?php

require_once 'AfricasTalkingGateway.php';

class GroupMessage
{
	private $vgroupno;
	private $vmessage;

	function __construct()
	{
		require_once 'topfile.php';

		if(isset($_REQUEST['vgroupno']) && isset($_REQUEST['vmessage']))
		{
			#sanitization
			$this->vgroupno       =   $db->real_escape_string($_REQUEST['vgroupno']);
			$this->vmessage        =   $db->real_escape_string($_REQUEST['vmessage']);
			#check empty
			if(!empty($this->vgroupno) && !empty($this->vmessage))
			{
				if($group_msg == 1)
				{
					#Database Queries within a loop are very expensive
					
					//$gd = $db->query("SELECT * FROM `sms_group_members` WHERE `group`='$this->vgroupno'");
					//	while($userdata = $gd->fetch_array())
					//	{
					//		$user_id = $userdata['member'];
					//		# get phone number
					//		$user_tbl_check = $db->query("SELECT * FROM `sms_contacts` WHERE `id`='$user_id'");
					//			$data_nos = $user_tbl_check->fetch_array();
					//			$listNos .= $data_nos['phone_number'].",";
					//	}
					//$grd = $db->query("SELECT * FROM `sms_groups` WHERE `id`='$this->vgroupno'");
					//	$group_data = $grd->fetch_array();
					//		$groupName = $group_data['group_name'];
					
					# GET PHONE NUMBERS AND GROUP DATA
					$gd = $db->query("SELECT 
										`g`.`group_name`,`c`.`phone_number` 
										FROM `sms_group_members` as `gm`
										inner join `sms_groups` as `g` on `g`.`id`=`gm`.`group`
										inner join `sms_contacts` as `c` on `c`.`id`=`gm`.`member`
										WHERE `gm`.`group`=2"
									);
					
					if($gd->num_rows > 0)
					{
						while($userdata = $gd->fetch_array())
						{
							$listNos .= $userdata['phone_number'].",";
							$groupName = $group_data['group_name'];
						}

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
						$message                       = $this->vmessage;

						$gateway                       = new AfricasTalkingGateway($username, $apikey);
						try
						{
							$results = $gateway->sendMessage($recipients, $message, $from);
							if($results)
							{
								$date     = date('d-M-Y H:i:s');
								//save record
								$saveRecord = $db->query("INSERT INTO `sms_logs`(`sent_to`,`message`,`date`,`by`)
									                                       VALUES('$groupName','$this->vmessage','$date','{$_SESSION['bulkadmin']}')");
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

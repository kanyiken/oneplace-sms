<?php
/**
 */

 class Send_Airtime{
    function __construct()
    {
        require_once 'topfile.php';
        
        if(isset($_POST) && isset($_POST['group_id']) && isset($_POST['airtimeamount']))
        {
            #sanitization
            if($contact_permit==1)
            {
                $this->group_id = $_POST['group_id'];
                $this->amount       = intval($_POST['airtimeamount']);
                
                #check empty
                if(!empty($this->group_id) && !empty($this->amount))
                {
                    if(intval($this->group_id) > 0)
                    {
                        if($this->amount >= 10 && $this->amount <= 10000)
                        {
                           $username                      = $as_username;
                           $apikey                        = $as_key;
                           $results                       = false;
                           $msg                           = '';
                           $space                         = ' ';
                           
																											$sql = "SELECT c.phone_number FROM `sms_group_members` as gm inner join sms_contacts as c on c.id=gm.member where gm.group='{$this->group_id}'";
																											$res = $db->query($sql);
																											if(!empty($res))
																											{
																												
																												while($recipient = $res->fetch_object())
																												{
																													$recipients[] = array(
																																																			"phoneNumber"	=> $recipient->phone_number,
																																																			"amount"						=> "KES ".$this->amount
																																																		);
																												}
																												
																												$recipientStringFormat = json_encode($recipients);

																												$gateway = new AfricasTalkingGateway($username, $apikey);
																												$insert_values = NULL;
																												
																												try {
																															$results = $gateway->sendAirtime($recipientStringFormat);
																															
																															foreach($results as $result) {
																																		$msg  .= '<p style="color:green"><i class="fa fa-check-square"></i>'.$space.$result->amount.$space.$result->status.' to '.$result->phoneNumber.'<br/>';
																																		
																																		if(!empty($result->errorMessage) && $result->errorMessage != 'None')
																																		{
																																								$msg .= '<p style="color:orange">'.$result->errorMessage.'</p><br/>';
																																		}
																																		$insert_values .= "('{$result->phoneNumber}','{$msg}','".date('Y-m-d H:i:s')."','{$_SESSION['bulkadmin']}'),";
																															}
																															$insert_values = trim($insert_values,',');
																												}
																												catch(AfricasTalkingGatewayException $e){
																															$msg = '<p style="color:orange"></i>'.$e->getMessage().'</p><br/>';
																												}
																												if($results)
																												{
																														if(!empty($insert_values))
																														{
																																$sql = "INSERT INTO `sms_logs`(`sent_to`,`message`,`date`,`by`)VALUES".$insert_values;
																																$insert = $db->query($sql);
																																if($insert)
																																{
																																	echo $msg;
																																	}else{
																																		echo $db->error;
																																		}
																														}
																												}
																											}
																											else
																											{
																												echo '<p style="color:orange">The group is empty!</p>';
																											}
                        }
                        else if($this->amount < 10)
                        {
                           echo '<p style="color:orange">The Minimum airtime you can send is KES 10</p>';
                        }
                        else
                        {
                           echo '<p style="color:orange">The Maximun airtime you can send is KES 10,000</p>';
                        }
                    }
                    else
                    {
                        echo '<p style="color:orange">The phone Number is invalid</p>';
                    }
                }
                else
                {
                    echo '<p style="color:orange">Please fill all fields</p>';
                }
            }
            else
            {
                echo '<p style="color:orange">You dont have permission to send airtime</p>';
            }
        }
    }
 }
 
 $airtime = new Send_Airtime();
?>
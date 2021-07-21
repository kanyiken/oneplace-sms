<?php
/**
 */

 class Send_Airtime{
    function __construct()
    {
        require_once 'topfile.php';
        
        if(isset($_POST) && isset($_POST['phone_number']) && isset($_POST['airtimeamount']))
        {
            #sanitization
            if($contact_permit==1)
            {
                $this->phone_number = $_POST['phone_number'];
                $this->amount       = intval($_POST['airtimeamount']);
                
                #check empty
                if(!empty($this->phone_number) && !empty($this->amount))
                {
                    if(strpos($this->phone_number,'+') !== false && strlen($this->phone_number)>10)
                    {
                        if($this->amount >= 10 && $this->amount <= 10000)
                        {
                           $username                      = $as_username;
                           $apikey                        = $as_key;
                           $results                       = false;
                           $msg                           = '';
                           $space                         = ' ';
                           
                           $recipients = array(
                                               array("phoneNumber"=>$this->phone_number, "amount"=>"KES ".$this->amount)
                                               );
                           $recipientStringFormat = json_encode($recipients);
                           
                           $gateway = new AfricasTalkingGateway($username, $apikey);
                           
                           
                           try {
                              $results = $gateway->sendAirtime($recipientStringFormat);
                              
                              foreach($results as $result) {
                                 $msg  .= '<p style="color:green"><i class="fa fa-check-square"></i>'.$space.$result->amount.$space.$result->status.' to '.$result->phoneNumber.'<br/>';
                                 
                                 if(!empty($esult->errorMessage))
                                 {
                                       $msg .= '<p style="color:orange">'.$esult->errorMessage.'</p><br/>';
                                 }
                              }
                           }
                           catch(AfricasTalkingGatewayException $e){
                              $msg = '<p style="color:orange"></i>'.$e->getMessage().'</p><br/>';
                           }
                           if($results)
                           {
                              
                              $insert = $db->query("INSERT INTO `sms_logs`(`sent_to`,`message`,`date`,`by`)
								VALUES('{$this->phone_number}','{$msg}','".date('Y-m-d H:i:s')."','{$_SESSION['bulkadmin']}')");
								if($insert)
								{
										echo $msg;
								}else{
										echo $db->error;
								}
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
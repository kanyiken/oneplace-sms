<?php
/**
* login a school user to the system
*/
session_start();

class LoginBulk
{
	private $username;
	private $password;


	function __construct()
	{
		if(isset($_REQUEST['loginusername']) && isset($_REQUEST['loginpassword']))
		{
			
			#config and AT
			require_once 'config.php';
			require_once 'AfricasTalkingGateway.php';
			#sanitization
			$this->username=$db->real_escape_string($_REQUEST['loginusername']);
			$this->password=$db->real_escape_string($_REQUEST['loginpassword']);
			
			#check empty
			if(!empty($this->username) && !empty($this->password))
			{
				#convert password
				$passhash = md5($this->password);
				#check against database for record
				$login = $db->query("SELECT * from `sms_users` WHERE `username`='$this->username' && `password`='$passhash'");

				if(($login->num_rows > 0))
				{
					# get some user data

					$userdata = $login->fetch_array();

						$userphone = $userdata['phone'];

						# check login pass type

						$passtype = "SELECT * FROM `sms_settings`";

						if($passtype_run = $db->query($passtype))
						{
							$passtype_data = $passtype_run->fetch_array();

							# fetch needed data, in our case 2 factor login,as_username,as_pass and as_sender

							$allow2factor = $passtype_data['security_2_factor'];
							$as_username  = $passtype_data['as_username'];
							$as_key       = $passtype_data['as_key'];
							$as_sender_id = $passtype_data['as_sender_id'];

							if($allow2factor == 2)
							{
								# Generate two factor code
								$remote_access_code            = rand(1000,9999);
								$db->query("UPDATE `sms_users` SET `login_pass`='$remote_access_code' WHERE `username`='$this->username'");
								# SMS Code	
								$username                      = $as_username;
								$apikey                        = $as_key;
								if($as_sender_id == ""){
									$from                      = NULL;
								}else{
									$from                      = $as_sender_id;
								}
								$recipients                    = $userphone;
								$message                       = "Your login code is ".$remote_access_code;
								$gateway                       = new AfricasTalkingGateway($username, $apikey);
								try
								{
								  $results = $gateway->sendMessage($recipients, $message, $from);
								  if($results)
								  {
								  	$_SESSION['sandbox']           = $this->username;
								  	echo $this->json_encoder("runsteptwo");
								  }
								}
								catch ( AfricasTalkingGatewayException $e )
								{
								  echo "Encountered an error while sending: ".$e->getMessage();
								}
							}else{
								
								$_SESSION['bulkadmin']         =$this->username;

								echo $this->json_encoder("successlogin");
							}
						}else{
							echo '<p style="color:orange;"> Something went wrong</p>';
						}
				}else{
					echo '<p style="color:orange;"> Wrong Username or Password</p>';
				}
			}else
			echo '<p style="color:orange;">Please fill all fields</p>';
		}
		else
		{
			echo '<p style="color:orange;">Something wierd happened. I also have no clue what.<p>';
		}
	}

	public function json_encoder($data)
	{
		$message = [];
		
		if(is_array($data))
		{
			foreach($data as $key => $value)
			{
				$message[$key] = $value;
			}
		}else{
			$message = ['feedback'=>$data];
		}
		
		header('Content-type: application/json');		
		return json_encode($message);
	}
}

$login = new LoginBulk();

?>

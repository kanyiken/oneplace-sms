<?php
/**
* login a school user to the system
*/
session_start();


class TwoFactor
{
	private $logcode;

	function __construct()
	{
		require_once 'config.php';
		
		if(isset($_SESSION['sandbox']))
		{
			if(isset($_REQUEST['twofactorpassword']))
			{
				#sanitization
				$this->code=$db->real_escape_string($_REQUEST['twofactorpassword']);
				#check empty
				if(!empty($this->code))
				{
					#check code against database for record
					$logintwo = $db->query("SELECT * from `sms_users` WHERE `login_pass`='$this->code' && `username`='{$_SESSION['sandbox']}'");

					if(($logintwo->num_rows > 0))
					{
						$_SESSION['bulkadmin']         =$_SESSION['sandbox'];
						unset($_SESSION['sandbox']);
						echo $this->json_encoder("passtoprofile");
					}else{
						echo '<p style="color:orange;">Incorrect Code</p>';
					}
				}else
				echo '<p style="color:orange;">Please insert your code</p>';
			}
		}else{
			echo $this->json_encoder("requestlogin");
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

$login = new TwoFactor();

?>
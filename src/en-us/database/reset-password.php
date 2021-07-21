<?php
class PasswordReset{
	
	public function __construct()
	{
		require __DIR__ . '/config.php';
		require __DIR__ . '/AfricasTalkingGateway.php';
		
		$settings = "SELECT * FROM `sms_settings`";

		if($settings_run = $db->query($settings))
		{
			$settingvalues = $settings_run->fetch_array();
			// Account settings details
			$as_username                = $settingvalues['as_username'];                                                                                                  
			$as_key                     = $settingvalues['as_key'];
			$as_sender_id               = $settingvalues['as_sender_id'];
		}
			
		$feedback = '<p style="color:orange;"> Something went wrong</p>';
		/****/
		if($as_sender_id == ""){
			$this->sms_from                      = NULL;
		}else{
			$this->sms_from                      = $as_sender_id;
		}
		$this->gateway                       = new AfricasTalkingGateway($as_username, $as_key);
		/****/
		$this->username = $db->real_escape_string($_REQUEST['loginusername']);
		$this->email = '';
		$this->phone = '';
		
		$result = $db->query("select `email`,`phone`,`username` from `sms_users` where `email` = '{$this->username}' or username = '{$this->username}' ");
		
		if($result->num_rows == 1)
		{
			$row = $result->fetch_object();
			$this->username	= $row->username;
			$this->email	= $row->email;
			$this->phone	= $row->phone;
			
			$method = $db->query("select `password_reset_type` from `sms_settings` limit 1")->fetch_object()->password_reset_type;
			$token = $this->_generate_code();
			$token_hash = $this->_encrypt_code($token);
			$token_expiry = strtotime("tomorrow");
			
			$query = $db->query("update `sms_users` set `password_token` = password('{$token_hash}'), `token_expiry` = '{$token_expiry}' where `username` = '$this->username' ");
		
			switch(strtolower($method))
			{
				case 'phone':
					$feedback = $this->_sms_code($token);
					break;
				default:
					$feedback = $this->_email_code($token, $token_hash);
			}
		}
		else
		{
			$feedback = '<p style="color:orange;">That user is a ghost.</p>';
		}
		
		echo $this->json_encoder($feedback);
	}
	
	private function _sms_code($token)
	{
		if(empty($this->phone))
		{
			return '<p style="color:orange;">You have not supplied us with a phone number, kindly contact admin.</p>';
		}
		
		$recipients                    = $this->phone;
		$message                       = "Use the following code to login: ".$token;
		
		try
		{
		  $results = $this->gateway->sendMessage($recipients, $message, $this->sms_from);
		  if($results)
		  {
			$_SESSION['sandbox']           = $this->username;
			
			return 'successreset';
		  }
		}
		catch ( AfricasTalkingGatewayException $e )
		{
		  return "Encountered an error while sending: ".$e->getMessage();
		}
	}
	
	private function _email_code($token, $token_hash = null)
	{
		if(!$token_hash){$token_hash = $this->_encrypt_code($token);}
	
		$site = $this->CurrentPageURL();
		$site = substr($site, 0, strpos($site, 'database/reset-password.php'));
		
		$message ='<p>Dear '.$this->username.',</p>
		
		<p>You are receiving this email because you requested for a password reset of your OnePlace SMS account hosted at '.$site.'. If you did not request for the reset, you may ignore this email and your account login details shall remain unchanged.</p>
		
		<p>To reset your password, enter the code below: <strong>'.$token.'</strong>, click on <a href="'.$site.'recover-pass.php?hash='.urlencode($token_hash).'&user='.urlencode($this->username).'">this link</a> or paste the URL below in your browser.</p>
		<p>'.$site.'recover-pass.php?hash='.urlencode($token_hash).'&user='.urlencode($this->username).'</p>
		<p>Thank you.<br />
		<br />
		<br />
		<em>For more queries, contact us at</em></p>
		
		<p>Oneplace Technologies<br />
		P.O Box 80063,00200<br />
		Nairobi - Kenya<br />
		Email: info@oneplacetechnologies.com . kanyikennedy@gmail.com | Phone: +254 705 992 941<br />
		<br />
		+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++<br />
		This system is distributed as open source.<br />
		You can do anything you want with it<br />
		Make sure the system footer remains &quot;Developed by Oneplace Technologies&quot; +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++</p>
		';
		
		require 'mail.php';
		$mail = new Mail();
		
		$mail->set_recipients($this->email)->set_subject('Password Reset | OnePlace SMS')->set_message($message)->send();
		$_SESSION['sandbox']           = $this->username;
		
		return 'successreset';
	}
	
	private function _generate_code()
	{
		$length = mt_rand(4,8);
		$chars = 'bcdfghjklmnprstvwxzaeiou23456789BCDFGHJKLMNPQRSTVWXYZAEU';
		
		for ($p = 0; $p < $length; $p++)
		{
			$result .= ($p%2) ? $chars[mt_rand(28, 55)] : $chars[mt_rand(0, 27)];
		}
		
		return $result;
	}
	
	private function _encrypt_code($code_)
	{
		return sha1(md5($code_));
	}
	
	public function json_encoder($data)
	{
		$message = [];
		
		if(is_array($data) || is_object($data))
		{
			$message = json_encode($data);
		}else{
			$message = ['feedback'=>$data];
		}
		
		header('Content-type: application/json');		
		return json_encode($message);
	}
	function CurrentPageURL()
	{
		//@copy http://webcheatsheet.com/php/get_current_page_url.php#d7dc4aa0080786da47546c62909e5c23
		$pageURL = $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
		$pageURL .= $_SERVER['SERVER_PORT'] != '80' ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"] : $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		
		return $pageURL;
	}
}

$reset = new PasswordReset();
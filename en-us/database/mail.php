<?php
/**
 *Email class
 *@author Samuel M<samuel@samuelmwangi.co.ke>
 **/
require_once "phpmailer/PHPMailerAutoload.php";

 class Mail{
	public $obj = null;
	
	public function __construct()
	{
		$this->obj = new PHPMailer();
		require "config.php";
		
		$sql = "select `email_protocol`,`email_from`,`email_from_name`,`email_smtp_host`,`email_smtp_secure`,`email_smtp_port`,`email_smtp_user`,`email_smtp_user`,`email_smtp_pass` from sms_settings limit 1";
		
		$result = $db->query($sql);
		if($result->num_rows < 1)
		{
			die("Please set up first!");
		}
		
		$settings = $result->fetch_object();
		$this->_set_protocol($settings)->_set_from($settings);
	}
	
	public function set_recipients($to, $name_ = NULL)
	{
		$this->obj->addAddress($to, $name_);
		
		return $this;
	}
	public function set_cc($cc, $name_ = NULL)
	{
		$this->obj->addCC($cc,$name_);
		
		return $this;
	}
	public function set_bcc($bcc, $name_)
	{
		$this->obj->addBCC($bcc, $name_);
		
		return $this;
	}
	public function add_attachment($attachment)
	{
		$this->obj->addAttachment($attachment);
		
		return $this;
	}
	public function set_message($message)
	{
		$this->obj->isHTML();
		$this->obj->Body = $message;
		$this->obj->AltBody = $this->obj->html2text($message);
		
		return $this;
	}
	public function set_subject($subject)
	{
		$this->obj->Subject = $subject;
		
		return $this;
	}
	public function send()
	{
		if(!$this->obj->send()) {
			return false;
		}
		else {
			return true;
		}
	}
	public function test($settings_obj)
	{
		//print_r($settings_obj);
		$this->_set_from($settings_obj)->_set_protocol($settings_obj);
		error_reporting(E_ALL);
		try
		{
			$this->set_recipients($settings_obj->email_from)->set_subject('Test')->set_message("This is test message. You are seeing this because It Works!");
			
			if($this->send())
			{
			return true;
			}
			else
			{
				echo 'Mailer Error: ' . $this->obj->ErrorInfo;
				return false;
			}
		}
		catch(Exception $e)
		{
			echo 'Mailer Error: ' . $this->obj->ErrorInfo;
			return false;
		}
		
	}
	/*******************************/
	private function _set_protocol($settings)
	{
		switch(strtolower($settings->email_protocol))
		{
			case 'mail':
				$this->obj->isMail();
				break;
			case 'qmail':
				$this->obj->isQmail();
				break;
			case 'smtp':
				$this->obj->isSMTP();
				$this->obj->Host = $settings->email_smtp_host;
				$this->obj->Port = $settings->email_smtp_port;
				$this->_set_security($settings);
				break;
			case 'sendmail':
				$this->obj->isSendmail();
				break;
			default:
				$this->obj->isMail();
		}
		
		return $this;
	}
	private function _set_from($settings)
	{
		$from = (filter_var($settings->email_from, FILTER_VALIDATE_EMAIL)) ? $settings->email_from : 'info@oneplace.co.ke';
		$from_name = (!empty($settings->email_from_name)) ? $settings->email_from_name : 'Oneplace SMS';
		
		$this->obj->setFrom($from, $from_name);
		
		return $this;
	}
	private function _set_security($settings)
	{
		if(strtolower($settings->email_protocol) == 'smtp')
		{
			switch(strtolower($settings->email_smtp_secure))
			{
				case 'ssl':
					$this->obj->SMTPSecure = 'ssl';
					break;
				case 'tls':
					$this->obj->SMTPSecure = 'tls';
					break;
				case '';
					$this->obj->SMTPSecure = '';
					break;
				default:
					$this->obj->SMTPSecure = false;
			}
			if($settings->email_smtp_user)
			{
				$this->obj->SMTPAuth = true;
				$this->obj->Username = $settings->email_smtp_user;
				$this->obj->Password = $settings->email_smtp_pass;
			}
		}
		
		return $this;
	}
 }
<?php
/*
 *Contacts import from CSV  class
 */

 class ContactsImport
 {
    private $file_location, $default_country_code = '+254', $db, $current_user, $messages;
    
    function __construct($location_)
    {
        require_once 'topfile.php';
        
        $this->file_location = $location_;
        $this->default_country_code	= isset($default_country_code) ? $default_country_code : $this->default_country_code;
        $this->db = $db;
        $this->current_user = $_SESSION['bulkadmin'];
        
        if(file_exists($this->file_location) && is_readable($this->file_location))
        {
            $file_data = fopen($this->file_location, 'r');
            $heading = (Object) fgetcsv($file_data); //skip line 1
            $contacts = array();
            $this->messages = array();
            $groups = array();
            $contact_groups = array();
            
            /***
             *Fetch the existing groups to avoid hitting the DB multiple times.
             *HINT: Performance over memory
             */
            $sql = "select id,lower(`group_name`) as group_name from `sms_groups`";
            $result = $this->db->query($sql);
            
            while($row = $result->fetch_object())
            {
                $groups[$row->group_name] = $row->id; //I know non-numeric keys aren't cool bt the alternative is more expensive
            }
            
            while($line = fgetcsv($file_data))
            {
                $this->cname           =ucwords($this->db->real_escape_string($line[0]));
				$this->corg            =ucwords($this->db->real_escape_string($line[3]));
				$this->cphone          =$this->db->real_escape_string($this->prepare_phone_number($line[1]));
                
                $contact_id = NULL;
                
                #check empty
				if(!empty($this->cname) && !empty($this->cphone))
				{
					$date = date('d-M-Y H:i:s');

					//Correct number to international format
					if(strpos($this->cphone,'0') === 0)
					{
						$this->cphone = preg_replace('/^(0)/', $this->default_country_code, $this->cphone); //To be updated. Default country code to go to settings
					}
					//verify phone number
					if(strpos($this->cphone,'+') !== false)
					{
						#check against database for record
						$duplicate=$this->db->query("SELECT * FROM `sms_contacts` WHERE `phone_number`='$this->cphone'");
                        $contact_id = NULL;

						if($duplicate->num_rows==0)
						{
							$insert = $this->db->query("INSERT INTO `sms_contacts`(`contact_name`,`organization`,`phone_number`,`added_by`,`date`)
								VALUES('$this->cname','$this->corg','$this->cphone','{$this->current_user}','$date')");
								if($insert)
								{
										$contact_id = $this->db->insert_id;
                                        $this->messages[] = '<p style="color:green"><i class="fa fa-check-square"></i> Contact added - '.$this->cphone.'</p>';
                                        
                                        
								}else{
                                        $this->messages[] = '<p style="color:orange"> An error occured. '.$this->db->error.'</p>';
                                        $contact_id = NULL;
								}
						}else{
							$this->messages[] = '<p style="color:orange"> '.$this->cphone.' already exists</p>';
                            $contact_id = $duplicate->fetch_object()->id;
                            
						}
                        
                        /*
                         *Add to group
                         */
                        if($contact_id && !empty(trim($line[2])))
                        {
                            $group_name = trim($line[2]);
							$group_id = (isset($groups[strtolower($group_name)])) ? $groups[strtolower($group_name)] : $this->add_group($group_name);
                            $groups[strtolower($group_name)] = $group_id; //Wierd hack. Save back to avoid duplicate add :-)
                            
                            $sql = "delete from sms_group_members where `group` = '{$group_id}' and `member` = '{$contact_id}'";
                            
                            $this->db->query($sql);
                            $date = date('d-M-Y H:i:s');
                            
                            $sql = "insert into sms_group_members (`group`, `member`, `added_by`,`date`) VALUES ('{$group_id}', '{$contact_id}', '{$this->current_user}', '{$date}')";
                            $this->db->query($sql);
                            $this->messages[] = '<p style="color:green"><i class="fa fa-check-square"></i> Contact added to group '.$group_name.'</p>';
                        }
					}else{
					 $this->messages[] = '<p style="color:orange">Phone number is not in full international format (+25478*****). '.$this->cphone.'</p>';
					}
				}else{
                    $this->messages[] =  '<p style="color:orange">Contact not added due to missing fields</p>';
				}
                /***********************/
            }
            if(!empty($this->messages))
            {
                foreach($this->messages as $msg)
                {
                    echo $msg;
                }
            }
        }
        else
        {
            echo '<p style="color:orange">File does not exist or is not readable</p>';
        }
    }
    
    function prepare_phone_number($phone_)
    {
        $phone_ = (string) $phone_;
        if(strpos($phone_,'7') === 0)
        {
            $phone_ = $this->default_country_code.$phone_; //To be updated. Default country code to go to settings
        }
        
        if(strpos($phone_,'0') === 0)
        {
            $phone_ = preg_replace('/^(0)/', $this->default_country_code, $phone_); //To be updated. Default country code to go to settings
        }
        
        return $phone_;
    }
    
    function add_group($group_name)
    {
        $date = date('d-M-Y H:i:s');
        $sql = "insert into `sms_groups` (`group_name`,`created_by`,`date`) values('{$group_name}', '{$this->current_user}', '{$date}')";
        
        $result = $this->db->query($sql);
        if($result)
        {
            $this->messages[] = "<p style='color : green'>Group {$group_name} successfully created</p>";
            return $this->db->insert_id;
        }
        return false;
    }
 }
 
 class FileUpload
 {
    private $_upload_dir = '../uploads',$_max_upload_size = 500000, $_allowed_file_type = array('csv'), $error_messages = array();
    public $upload_location,$error = FALSE;
    
    function __construct()
    {
        if(!isset($_FILES) || empty($_FILES['upload_file']))
		{
			$this->error_messages[] = 'No File Uploaded';
			$this->error = TRUE;
            return FALSE;
		}
		
		$uploaded_file = $_FILES['upload_file'];
        
        $upload_location = $this->_upload_dir.'/'.basename($uploaded_file['name']);
        
        if(!in_array(pathinfo($uploaded_file['name'],PATHINFO_EXTENSION), $this->_allowed_file_type))
        {
            $this->error_messages[] = 'Filetype not allowed';
            $this->error = TRUE;
            return FALSE;
        }
        if($uploaded_file['size'] > $this->_max_upload_size)
        {
            $this->error_messages[] = 'File bigger than allowed size. Max allowed file size is 5MB.';
            $this->error = TRUE;
            return FALSE;
        }
        
        $count = 0;
        while(file_exists($upload_location))
        {
            $upload_location = $this->_upload_dir.'/'.++$count.'_'.basename($uploaded_file['name']);
        }
								
        if (!is_dir($this->_upload_dir)) {
									mkdir($this->_upload_dir, 0777, true);
								}
								
        if(!is_writable($this->_upload_dir))
        {
            $this->error_messages[] = 'Permission denied. Kindly confirm if the <code>'.realpath($this->_upload_dir).'</code> directory exists and is writable.';
            $this->error = TRUE;
            return FALSE;
        }
								
								while(file_exists($upload_location))
								{
									$ext = pathinfo($upload_location, PATHINFO_EXTENSION);
									$upload_location = pathinfo($upload_location, PATHINFO_FILENAME).'_1.'.$ext;
								}
								
        if(!move_uploaded_file($uploaded_file['tmp_name'], $upload_location))
        {
            $this->error_messages[] = 'File could not be uploaded. Kindly confirm if the directory is writable.';
            $this->error = TRUE;
            return FALSE;
        }
        $this->upload_location = $upload_location;
    }
    function get_error_messages()
    {
        $message = '';
        foreach($this->error_messages as $msg)
        {
            $message.="<p style='color : orange'>{$msg}</p>";
        }
        
        return $message;
    }
    function upload_location()
    {
        return $this->upload_location;
    }
 }
 $file = new FileUpload();
 if($file->error)
 {
    echo $file->get_error_messages();
 }
 else
 {
    $import = new ContactsImport($file->upload_location());
 }
 
?>
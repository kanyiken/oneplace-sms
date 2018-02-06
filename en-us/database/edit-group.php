<?php
/**
* 
*/
class EditGroup
{
	private $gidentity;
	private $editgroupname;

	function __construct()
	{
		require_once 'topfile.php';

		if(isset($_REQUEST['editgroupname']) && isset($_REQUEST['gidentity']))
		{
			#sanitization
			$this->gidentity        =  $db->real_escape_string($_REQUEST['gidentity']);
			$this->editgroupname    =  ucwords($db->real_escape_string($_REQUEST['editgroupname']));
			#check empty
			if(!empty($this->editgroupname))
			{
				$date = date('d-M-Y H:i:s');
				#check against database for record
					$update = $db->query("UPDATE `sms_groups` SET `group_name`='$this->editgroupname' WHERE `id`='$this->gidentity'");
						if($update)
							{
								# Write log
								$logtext = $_SESSION['bulkadmin']." has updated group ".$this->editgroupname." on ".date('d-M-Y H:i:s');
								$log = $db->query("INSERT INTO `sms_activity`(`activity_log`)VALUES('$logtext')");

								echo '<p style="color:green"><i class="fa fa-check-square"></i> Group updated</p>';

							}else{
								echo $db->error();
							}
			}else{
				echo '<p style="color:orange">Please provide new group name</p>';
			}
		}
	}
}

$editgroup = new EditGroup();

?>

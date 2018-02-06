<?php
/*
 *An SMS Schedular for messages to be sent later
 *@author Samuel M<samuel@samuelmwangi.co.ke>
 *@package OneplaceSMS
 *@example usage $ScheduledSmsObj = new ScheduledSms(Array $ScheduledMessagesArray);
 *@param $ScheduledMessagesArray Array of arrays in the following formart array(array('text','recipients','time'),array('text','recipients','time'))
 *
 **/
class ScheduledSms
{
    private $messages_array = array(), $error_messages = array(), $db = NULL;
    public $error = FALSE;
    
    function __construct($messages_array_)
    {
        if(empty($messages_array_) || !is_array($messages_array_))
        {
            $this->error = TRUE;
            $this->error_messages[] = "Message can not be blank!";
        }
        
        if($this->error === FALSE)
        {
            require 'config.php';
            
            $this->db = $db;
            $this->current_user = $_SESSION['bulkadmin'];
            
            foreach($messages_array_ as $message)
            {
                $text = $this->db->escape_string($message['text']);
                $recipients = $message['recipients'];
                $scheduled_time = strtotime($message['time']) > time() ? date('Y-m-d H:i:s', strtotime($message['time'])) : NULL; //Cannot be in the past
                if(!empty($text) && !empty($recipients) && $scheduled_time)
                {
                    $sql = "INSERT INTO `sms_scheduled_messages`(`message`,`sent_by`,`scheduled_time`,`date_sent`) VALUES('{$text}', '{$this->current_user}','{$scheduled_time}', now())";
                    $result = $this->db->query($sql);
                    
                    $message_id = $this->db->insert_id;
                    if($result)
                    {
                        $recipients_sql = "INSERT INTO `sms_message_recipients`(`message_id`,`phone_number`, `status`) VALUES";
                        $count = 0;
                        foreach($recipients as $recipient)
                        {
                             $recipients_sql .= "('{$message_id}', '{$recipient}', 'new'), ";
                             $count += 1; //Atleast it's better than multiple inserts
                        }
                        
                        $recipients_sql = trim($recipients_sql, ', ');
                        if($count)
                        {
                            $this->db->query($recipients_sql);
                        }
                    }
                    else
                    {
                        $this->error = TRUE;
                        $this->error_messages[] =  "There was an error in saving the message : ".$this->db->error;
                    }
                }
            }
            return $this; //I love chaining methods, that's why :-)
        }
        else
        {
            return false;
        }
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
}
?>
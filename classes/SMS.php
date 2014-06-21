<?php
class SMS{
	private $_mobile,
			$_message,
			$_username,
			$_password,
			$_senderID;
	public $error;
	
	public function __construct($username, $password, $senderid){
		$this->_mobile = NULL;
		$this->_message =NULL;
		$this->error=NULL;

		// RedSMS.in username
		$this->_username = $username;
		
		// RedSMS.in password
		$this->_password = $password;
		
		// RedSMS.in sender id	
		$this->_senderID = $senderid; 
	}
	
	//Using send function we are sending SMS to user mobile!! 
	
	//$url is a address which needs to be called to send sms to user's mobile!!
	public function send($mobile,$message){
	
		$this->_mobile = $mobile;
		$this->_message = urlencode($message);
		
		$url = "http://login.redsms.in/API/SendMessage.ashx?user={$this->_username}&password={$this->_password}&phone={$this->_mobile}&text={$this->_message}&type=t&senderid={$this->_senderID}";
		
		//we're using cURL to access the $url and retrieve its data!!!
		
		$ch = curl_init();
		$timeout = 500000;
		curl_setopt($ch, CURLOPT_URL, $url);
		/** If PROXY
		
		**curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0); // If PROXY!!
		**curl_setopt($ch, CURLOPT_PROXY, '172.16.30.20:8080'); // PROXY 
		
		**/
		//curl_setopt($ch, CURLOPT_POST, TRUE);             // Use POST method
		//curl_setopt($ch, CURLOPT_POSTFIELDS, "var1=1&var2=2&var3=3");  // Define POST data values
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		if($data==='Sent'){ //RedSMS.in returns 'Sent' code when SMS is sent successfully!
				return 1;
			}
		else{
			$this->error = $data; //Else $data stores error produced while sending sms using RedSMS.in!
			return $this->error;
		}
	}
}

	
/**
**
********************************************************************************************************
** Created by Harsh Vardhan Ladha // www.harshladha.in //
**/
?>

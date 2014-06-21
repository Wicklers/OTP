<?php
class OTP{
		private $_mobile,
				$_message,
				$_CODE;
				
				
		// OTP Construct function with arguments to create OTP code.
		
		public function __construct($length,$strength){ 
			$this->_generateOTP($length,$strength);
		}
		
		// Retrieving OTP CODE to form the SMS text contents
		
		public function getOTPCode(){
				return $this->_CODE;
			}
		
		//Sending OTP to the mobile specified, with the message. Using SMS Class!
		
		public function send($mobile,$message){
				$this->_mobile = $mobile;
				$this->_message = $message;
				
				// API call to send sms
				// Here we are using "REDSMS.IN" as our SMS provider . . 			
				$sms = new SMS('test', '123', 'TESTIN'); // first argument is username, second is password, third is Sender ID!!
				if($sms->send($this->_mobile, $this->_message)){
					return 1; // SENT Successfully!!
				}
				// If there is some with the SMS API, (Here we are using REDSMS.IN!), We handle the error as below:
				else{
					echo 'Red SMS ERROR :  ' . $sms->error;
					Session::delete('OTPCode');
					die();
				}
			}
			
		//Here we are generating the OTP Code!! This function is called when the OTP object is created!
		
		
		private function _generateOTP($length, $strength){
			$vowels = 'aeiou';
			$consonants = 'bcdfghjklmnpqrstvwyxz';
				if ($strength & 1) 
				{
					$consonants .= 'BCDFGHJKLMNPQRSTVWXYZ';
				}
				if ($strength & 2) 
				{
					$vowels .= "AEIOU";
				}
				if ($strength & 4) 
				{
					$consonants .= '23456789';
				}
				if ($strength & 8) 
				{
					$consonants .= '@#$%';
				}
				$password = '';
				$alt = time() % 2;
				for ($i = 0; $i < $length; $i++) 
				{
					if ($alt == 1) 
					{
						$password .= $consonants[(rand() % strlen($consonants))];
						$alt = 0;
					} 
					else 
					{
						$password .= $vowels[(rand() % strlen($vowels))];
						$alt = 1;
					}
				}
				
				$this->_CODE = $password;
				Session::put('OTPCode', $this->_CODE);
			}
			
			
		// Verifying the OTP entered by the user! If it is correct the function returns 1 else it returns 0
		
		
		public function verifyOTP($response_code){
				if(Session::exists('OTPCode') && $response_code===Session::get('OTPCode')){
						Session::delete('OTPCode');
						return 1;
					}
				else{
						return 0;
					}
			}
	}
	
/**
**
********************************************************************************************************
** Created by Harsh Vardhan Ladha // www.harshladha.in //
**/
?>

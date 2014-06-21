<?php																							
require_once 'core/init.php';																		
																								
if(!Input::exists()){																						
?>																						
    <form method="post" action="index.php">													
    <input type="text" maxlength="10" placeholder="Enter Mobile Number" name="mobile"><br/>	
    <input type="submit" value="Send OTP">													
    </form>																						
<?php																					
}																							
else if(Input::exists() && Input::get('mobile')!=''){
		$otp = new OTP(8,4); // defining length and strength of the OTP CODE!!
		
		//GET the OTP Code in $code;
		
		$code = $otp->getOTPCode();
		
		//Form the contents of the text message that needs to be send!
		
		$message = "Your OTP is : $code ";
		
		if($otp->send(Input::get('mobile'), $message) && Session::loginAttempt('OTP')){					
				Session::put('OTP Sending', 'OTP Sent Successfully');							
				Redirect::to('example.php');		
		}
		else{																					
				echo "OTP Sending Error ... login attempt = " . Session::loginAttempts('OTP');	
		}																					
}																							
if(Session::exists('OTP Sending')){																
		echo Session::get('OTP Sending') . "<br/>";												
		Session::delete('OTP Sending');															
		if(Session::loginAttempts('OTP')){														
			?>																					
        <form action="example.php" method="post">													
        <input type="text" maxlength="8" placeholder="Enter OTP Here" name="OTP_response_code"> 
        <input type="submit" Value="Verify">													
        </form>																					
        <?php																						
			}																					
		else{																					
				echo 'You have been blocked.. contact Administrator';							
			}																					
		}																						
if(Input::exists() && Input::get('OTP_response_code')!=''){										
		$otp=new OTP();																			
		if($otp->verifyOTP(Input::get('OTP_response_code'))){									
				Session::deleteloginAttempt('OTP');												
				echo 'Yipppeeee Verified';														
			}																					
		else{																					
				Session::put('OTP Sending', 'Incorrect, Enter Again');							
				if(Session::loginAttempt('OTP')){												
						Redirect::to('index.php');												
					}																			
					
		}
}
?>

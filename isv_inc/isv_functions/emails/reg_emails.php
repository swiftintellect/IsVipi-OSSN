<?php
	function sendValidationEmail($email,$fullName,$validCode,$sEmail,$sTitle,$sURL,$sLogo){
		$to = $email;
		$subject = "Account Activation";
		$message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
		<html xmlns='http://www.w3.org/1999/xhtml'>
		 <head>
		  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		  <title>Account Activation</title>
		  <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
		</head>
		<body style='margin: 0; padding: 0;'>
		 <table align='center' cellpadding='0' cellspacing='0' width='700'>
		 <!-- header section-->
		 <tr>
		  <td align='left' bgcolor='#0099FF' style='padding: 10px;'>
		 <img src='".$sURL."/isv_inc/isv_style.lib/site/imgs/".$sLogo."' alt='". $sTitle ." Logo' width='150' style='display:inline-block; float:left' />
		 
		  </td>
		 </tr>
		 <!--/ header-->
		 <tr>
		  <td bgcolor='#F4F4F4' style='padding: 10px;'>
		   Dear ".$fullName.",<br />
		   <p>Your account has been created. Please click the link below to activate your account and sign in.</p>
							  <p> Link: ".$sURL."/p/users/validate/".$validCode."</p>
							  <p> If for some reason you cannot click on the link above, copy and paste it in your browser.</p>
		  </td>
		 </tr>
		 <tr>
		  <td bgcolor='#0099FF' style='padding: 10px; font-weight:600; color:#FFFFFF; line-height:22px'>
		   Best Regards,<br />
		   ".$sTitle." Team<br />
		   ".$sURL."
		  </td>
		 </tr>
		</table>
		</body>
		</html>";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		$headers .= 'From: '.$sTitle.' <'.$sEmail.'>' . "\r\n";
		mail($to,$subject,$message,$headers);	

	}
	
	function sendCustom($email,$fullName,$message,$sEmail,$sTitle,$sURL,$sLogo){
		$to = $email;
		$subject = "New Member Account";
		$message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
		<html xmlns='http://www.w3.org/1999/xhtml'>
		 <head>
		  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		  <title>New Member Account</title>
		  <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
		</head>
		<body style='margin: 0; padding: 0;'>
		 <table align='center' cellpadding='0' cellspacing='0' width='700'>
		 <!-- header section-->
		 <tr>
		  <td align='left' bgcolor='#0099FF' style='padding: 10px;'>
		 <img src='".$sURL."/isv_inc/isv_style.lib/site/imgs/".$sLogo."' alt='". $sTitle ." Logo' width='150' style='display:inline-block; float:left' />
		 
		  </td>
		 </tr>
		 <!--/ header-->
		 <tr>
		  <td bgcolor='#F4F4F4' style='padding: 10px;'>
		   <p>Dear ".$fullName.",<p>
		   <div>$message</div>
		  </td>
		 </tr>
		 <tr>
		  <td bgcolor='#0099FF' style='padding: 10px; font-weight:600; color:#FFFFFF; line-height:22px'>
		   Best Regards,<br />
		   ".$sTitle." Team<br />
		   ".$sURL."
		  </td>
		 </tr>
		</table>
		</body>
		</html>";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		$headers .= 'From: '.$sTitle.' <'.$sEmail.'>' . "\r\n";
		mail($to,$subject,$message,$headers);	

	}
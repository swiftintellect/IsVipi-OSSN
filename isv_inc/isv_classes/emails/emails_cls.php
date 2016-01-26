<?php
class emails {
		
	public function __construct(){}
	
	public function send_email($to_email,$to_name,$subject,$msg){
		//set referer
		$from_url = $_SERVER['HTTP_REFERER'];
		
		//require mailer class
		require_once(ISVIPI_CLASSES_BASE . 'emails/mailer/mailer_autoload.php');
		
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		
		// Set PHPMailer to use the sendmail transport
		$mail->isSendmail();
		
		//Set who the message is to be sent from
		$mail->setFrom(ISV_DEFAULT_EMAIL_FROM, ISV_SITE_TITLE);
		
		//Set an alternative reply-to address
		$mail->addReplyTo(ISV_DEFAULT_EMAIL_FROM, ISV_SITE_TITLE);
		
		//Set who the message is to be sent to
		$mail->addAddress($to_email, $to_name);
		
		//Set the subject line
		$mail->Subject = $subject;
		
		//Message
		$mail->msgHTML($this->create_html_msg($to_name,$msg));
		
		//Replace the plain text body with one created manually
		$mail->AltBody = $msg;
		
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');
		
		//send the message, check for errors
		if (!$mail->send()) {
			 $_SESSION['isv_error'] = 'The email was not sent. The reported error: '.$mail->ErrorInfo.'';
			 header('location:'.$from_url.'');
			 exit();
		}

	}
	
	public function send_mass_mail($m_load,$subject,$msg){
		//set referer
		$from_url = $_SERVER['HTTP_REFERER'];
		
		//require mailer class
		require_once(ISVIPI_CLASSES_BASE . 'emails/mailer/mailer_autoload.php');
		
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		
		// Set PHPMailer to use the sendmail transport
		$mail->isSendmail();
		
		//Set who the message is to be sent from
		$mail->setFrom(ISV_DEFAULT_EMAIL_FROM, ISV_SITE_TITLE);
		
		//Set an alternative reply-to address
		$mail->addReplyTo(ISV_DEFAULT_EMAIL_FROM, ISV_SITE_TITLE);
		
		//Set the subject line
		$mail->Subject = $subject;
		
		//Replace the plain text body with one created manually
		$mail->AltBody = $msg;
		
		foreach ($m_load as $key => $mi) { 
			$mail->addAddress($mi['email'], $mi['name']);
			
			//Message
			$mail->msgHTML($this->create_html_msg($mi['name'],$msg));
			
			//Replace the plain text body with one created manually
			$mail->AltBody = $msg;
			
			if (!$mail->send()) {
				 $_SESSION['isv_error'] = "Mailer Error (".str_replace("@", "&#64;", $row["email"]).')'.$mail->ErrorInfo.'<br />';
				 header('location:'.$from_url.'');
				 exit();
			}
			
			// Clear all addresses and attachments for next loop
			$mail->clearAddresses();
    		$mail->clearAttachments();
		
		}
		
		
	}
	
	public function create_html_msg($to_name,$msg){
		$siteInfo = new siteManager();
		$s_s = $siteInfo->getSiteSettings();
		$s_d = $siteInfo->getSiteInfo();
		
		if($to_name == "guest"){
			$salute = "";
		} else {
			$salute = "<p>Dear $to_name,</p>";
		}
		return 
			"<table align='center' cellpadding='0' cellspacing='0' width='700'>
			 <tr>
			  <td align='left' bgcolor='#0099FF' style='padding: 10px;'>
			 <img src='" . ISVIPI_INC_BASE . "isv_style.lib/site/imgs/" . $s_s['logo'] . "' alt='" . ISV_SITE_TITLE . " Logo' width='150' style='display:inline-block; float:left' />
			 
			  </td>
			 </tr>
			 <!--/ header-->
			 <tr>
			  <td bgcolor='#F4F4F4' style='padding: 10px;'>
			   $salute
			   <div>$msg</div>
			  </td>
			 </tr>
			 <tr>
			  <td bgcolor='#0099FF' style='padding: 10px; font-weight:500; color:#FFFFFF; line-height:22px'>
			   Regards,<br />
			   " . ISV_SITE_TITLE . "<br />
			   " . $s_d['s_url'] . "
			  </td>
			 </tr>
			</table>";
		
	}
	
		
}
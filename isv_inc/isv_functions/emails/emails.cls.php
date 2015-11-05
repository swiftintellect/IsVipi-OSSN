<?php
	class emails {
		private $s_email;
		private $s_title;
		private $s_url;
		private $s_logo;
		private $admin_name;

	public function __construct(){
		$siteInfo = new siteManager();
		$s_s = $siteInfo->getSiteSettings();
		$s_d = $siteInfo->getSiteInfo();
		
		$this->s_email = $s_d['s_email'];
		$this->s_title = $s_d['s_title'];
		$this->s_url = $s_d['s_url'];
		$this->s_logo = $s_s['logo'];
		
		//we then get the logged in admin details
		require_once(ISVIPI_ADMIN_CLS_BASE .'init.cls.php');
		$track = new admin_security();
		$admin = $track->admin_details($_SESSION['isv_admin_id']);
		$this->admin_name = $admin['name'];
	}
		
	
	public function custom_email($email,$subject,$fullName,$message){
		
		$to = $email;
		$subject = $subject;
		$message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
		<html xmlns='http://www.w3.org/1999/xhtml'>
		 <head>
		  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		  <title>$subject</title>
		  <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
		</head>
		<body style='margin: 0; padding: 0;'>
		 <table align='center' cellpadding='0' cellspacing='0' width='700'>
		 <!-- header section-->
		 <tr>
		  <td align='left' bgcolor='#0099FF' style='padding: 10px;'>
		 <img src='".$this->s_url."/isv_inc/isv_style.lib/site/imgs/".$this->s_logo."' alt='". $this->s_title ." Logo' width='150' style='display:inline-block; float:left' />
		 
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
		   ".$this->admin_name."<br />
		   ".$this->s_title." Team<br />
		   ".$this->s_url."
		  </td>
		 </tr>
		</table>
		</body>
		</html>";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		$headers .= 'From: '.$this->s_title.' <'.$this->s_email.'>' . "\r\n";
		mail($to,$subject,$message,$headers);	

	}
	
	
	}
<?php
/*******************************************************
 *   Copyright (C) 2014  http://isvipi.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 ******************************************************/ 
 
 //////////////////////////////////////////
 //// ACCOUNT ACTIVATION EMAIL ///////////
 /////////////////////////////////////////
function sendActEmail($site_url,$site_email,$user,$site_title,$randomstring,$email){
	global $site_url, $site_title, $site_email;
	global $logoname;
	if (!isset($logoname)){$logoname == "logo.png";}
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
 <img src='".$site_url."/inc/style.lib/images/site/".$logoname."' alt='". $site_title ." Logo' width='150' style='display:inline-block; float:left' />
 <div style='float:left;margin-left:20px; margin-top:15px;color:#FFFFFF; font-size:28px; font-weight:700'>
 ".$site_title."
 </div>
  </td>
 </tr>
 <!--/ header-->
 <tr>
  <td bgcolor='#F4F4F4' style='padding: 10px;'>
   Dear ".$user.",<br />
   <p>Your account at ".$site_title." has been created. You will however need to validate your email before you can log in. To validate your email, please click the link below.</p>
                      <p> Link: ".$site_url."/auth/activate/".$randomstring."</p>
                      <p> If for some reason you cannot click on the link above, copy and paste it in your browser.</p>
  </td>
 </tr>
 <tr>
  <td bgcolor='#0099FF' style='padding: 10px; font-weight:700; color:#FFFFFF'>
   Best Regards,<br />
   ".$site_title." Team<br />
   ".$site_url."
  </td>
 </tr>
</table>
</body>
</html>";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$headers .= 'From: '.$site_title.' <'.$site_email.'>' . "\r\n";
mail($to,$subject,$message,$headers);	
}

//////////////////////////////////////////////
///////// PASSWORD RECOVERY EMAIL ///////////
////////////////////////////////////////////
function sendRecEmail($recov_email,$randomstring,$site_title,$site_email,$username,$site_url){
	global $site_url, $site_title, $site_email;
	global $logoname;
	if (!isset($logoname)){$logoname == "logo.png";}
$to = $recov_email;
$subject = "Recover Password";
$message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
 <head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
  <title>Recover Password</title>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
</head>
<body style='margin: 0; padding: 0;'>
 <table align='center' cellpadding='0' cellspacing='0' width='700'>
 <!-- header section-->
 <tr>
  <td align='left' bgcolor='#0099FF' style='padding: 10px;'>
 <img src='".$site_url."/inc/style.lib/images/site/".$logoname."' alt='". $site_title ." Logo' width='150' style='display:inline-block; float:left' />
 <div style='float:left;margin-left:20px; margin-top:15px;color:#FFFFFF; font-size:28px; font-weight:700'>
 ".$site_title."
 </div>
  </td>
 </tr>
 <!--/ header-->
 <tr>
  <td bgcolor='#F4F4F4' style='padding: 10px;'>
   Dear ".$username.",<br />
   <p>You recently requested to change your password at ".$site_title." </p>
    <p> Your password reset link is ".$site_url."/auth/recover_password/".$randomstring."</p>
    <p> -------------------------------</p>
    <p> If you did not make such a request, please ignore this email.</p>
  </td>
 </tr>
 <tr>
  <td bgcolor='#0099FF' style='padding: 10px; font-weight:700; color:#FFFFFF'>
   Best Regards,<br />
   ".$site_title." Team<br />
   ".$site_url."
  </td>
 </tr>
</table>
</body>
</html>";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$headers .= 'From: '.$site_title.' <'.$site_email.'>' . "\r\n";
mail($to,$subject,$message,$headers);	
}

//////////////////////////////////////////////
///////// NEW MESSAGE NOTIFICATION //////////
////////////////////////////////////////////
function sendNewMsgNotif($toUser,$toEmail,$fromUser,$message){
	global $site_url, $site_title, $site_email;
	global $logoname;
	if (!isset($logoname)){$logoname == "logo.png";}
$to = $toEmail;
$subject = "You have a new message from $fromUser";
$message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
 <head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
  <title>You have a new message from $fromUser</title>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
</head>
<body style='margin: 0; padding: 0;'>
 <table align='center' cellpadding='0' cellspacing='0' width='700'>
 <!-- header section-->
 <tr>
  <td align='left' bgcolor='#0099FF' style='padding: 10px;'>
 <img src='".$site_url."/inc/style.lib/images/site/".$logoname."' alt='". $site_title ." Logo' width='150' style='display:inline-block; float:left' />
 <div style='float:left;margin-left:20px; margin-top:15px;color:#FFFFFF; font-size:28px; font-weight:700'>
 ".$site_title."
 </div>
  </td>
 </tr>
 <!--/ header-->
 <tr>
  <td bgcolor='#F4F4F4' style='padding: 10px;'>
   Dear ".$toUser.",<br />
   <p>You have received a new message from  ".$fromUser."</p>
   <p>=======================================</p>
    <p> $message </p>
   <p>=======================================</p>
    <p> -------------------------------</p>
    <p> To reply to this message, please follow this link ".$site_url."/read_pm/".$fromUser."</p>
  </td>
 </tr>
 <tr>
  <td bgcolor='#0099FF' style='padding: 10px; font-weight:700; color:#FFFFFF'>
   Best Regards,<br />
   ".$site_title." Team<br />
   ".$site_url."
  </td>
 </tr>
</table>
</body>
</html>";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$headers .= 'From: '.$site_title.' <'.$site_email.'>' . "\r\n";
mail($to,$subject,$message,$headers);	
}

//////////////////////////////////////////////
///////// NEW MESSAGE NOTIFICATION //////////
////////////////////////////////////////////
function newUserRegistered($user,$email){
	global $site_url, $site_title, $site_email;
	global $logoname;
	if (!isset($logoname)){$logoname == "logo.png";}
$to = $site_email;
$subject = "New User Registration";
$message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
 <head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
  <title>New User Registration</title>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
</head>
<body style='margin: 0; padding: 0;'>
 <table align='center' cellpadding='0' cellspacing='0' width='700'>
 <!-- header section-->
 <tr>
  <td align='left' bgcolor='#0099FF' style='padding: 10px;'>
 <img src='".$site_url."/inc/style.lib/images/site/".$logoname."' alt='". $site_title ." Logo' width='150' style='display:inline-block; float:left' />
 <div style='float:left;margin-left:20px; margin-top:15px;color:#FFFFFF; font-size:28px; font-weight:700'>
 ".$site_title."
 </div>
  </td>
 </tr>
 <!--/ header-->
 <tr>
  <td bgcolor='#F4F4F4' style='padding: 10px;'>
   Dear Admin,<br />
   <p>A new user has registered on your site.</p>
    <p> Username: $user </p>
	<p> Email: $email </p>
    <p> -------------------------------</p>
    <p> To deactivate these notifications, please go to your general settings of admin back-end</p>
  </td>
 </tr>
 <tr>
  <td bgcolor='#0099FF' style='padding: 10px; font-weight:700; color:#FFFFFF'>
   Best Regards,<br />
   Your Most Faithful Autosystem<br />
   ".$site_url."
  </td>
 </tr>
</table>
</body>
</html>";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$headers .= 'From: '.$site_title.' <'.$site_email.'>' . "\r\n";
mail($to,$subject,$message,$headers);	
}

//////////////////////////////////////////////
///////// FRIEND REQUEST NOTIFICATION ///////
////////////////////////////////////////////
function sendFReqnotif($toUser,$toEmail,$fromUser){
	global $site_url, $site_title, $site_email;
	global $logoname;
	if (!isset($logoname)){$logoname == "logo.png";}
$to = $toEmail;
$subject = "You have a Friend Request";
$message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
 <head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
  <title>You have a Friend Request</title>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
</head>
<body style='margin: 0; padding: 0;'>
 <table align='center' cellpadding='0' cellspacing='0' width='700'>
 <!-- header section-->
 <tr>
  <td align='left' bgcolor='#0099FF' style='padding: 10px;'>
 <img src='".$site_url."/inc/style.lib/images/site/".$logoname."' alt='". $site_title ." Logo' width='150' style='display:inline-block; float:left' />
 <div style='float:left;margin-left:20px; margin-top:15px;color:#FFFFFF; font-size:28px; font-weight:700'>
 ".$site_title."
 </div>
  </td>
 </tr>
 <!--/ header-->
 <tr>
  <td bgcolor='#F4F4F4' style='padding: 10px;'>
   Dear ".$toUser.",<br />
   <p>You have received a new friend request from <b>".$fromUser."</b>.</p>
    <p> Please login to your ".$site_title." account and approve or reject the friend request. </p>
    <p> -------------------------------</p>
    <p> Please visit ".$site_url." and log in.</p>
  </td>
 </tr>
 <tr>
  <td bgcolor='#0099FF' style='padding: 10px; font-weight:700; color:#FFFFFF'>
   Best Regards,<br />
   ".$site_title." Team<br />
   ".$site_url."
  </td>
 </tr>
</table>
</body>
</html>";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$headers .= 'From: '.$site_title.' <'.$site_email.'>' . "\r\n";
mail($to,$subject,$message,$headers);	
}

?>
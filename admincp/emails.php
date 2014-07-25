<?php include_once'header.php';?>
<?php include_once'sidebar.php';?>
    <!-- Start of the container-->
    <div class="container-admin">
      <div class="page-header">
		<ul class="breadcrumb breadcrumb-admin">
  			<li><i class="fa fa-home"></i> <?php echo HOME ?></li>
  			<li class="active"><?php echo EMAILS ?></li>
            <span class="donate_support"><span class="label label-danger"><?php echo DONATE ?> </span></span>
        <div class="donate">
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8EKWYJABNLDE2" data-toggle="tooltip" data-placement="bottom" target="_blank" title="<?php echo DONATE_TEXT ?>"><img src="<?php echo ISVIPI_STYLE_URL.'images/donate.png';?>" width="100%" alt="" /></a>
        </div>
        </ul>
     </div>
     <!-- Start of main_content-->
     <div class="main_content">
     <div style="clear:both"></div>
     <div class="dash_admin_panel_cont"> <!--start of dash_cont_stat-->
       <div class="row">
     	<div class="panel panel-default midi-left">
    	<div class="panel-heading"><strong><?php echo "Send Mass Emails" ?> </strong></div>
        <div class='alert alert-info'>
        The system may take longer depending on the number of emails to be sent, as well as your server limitations.
        </div>
          <form method="post" action="<?php echo ISVIPI_URL.'conf/massMails/' ?>">
          <input type="hidden" name="action" value="sEmail">
          <table>
           <tbody>
           <tr>
           <td><?php echo "To" ?>: 
    <select name="to" class="form-control input-width-mini" required="required">
           <option selected value="5"><?php echo "All Members" ?></option>
           <option value="1"><?php echo "Active Members" ?></option>
           <option value="3"><?php echo "Suspended Members" ?></option>
           <option value="9"><?php echo "Unvalidated Members" ?></option>
        </select>
           </td>
           </tr>
           <tr>
           <td><?php echo "Subject:" ?>
           <input type="text" class="form-control" name="subject" required="required"/> 
           </td>
           </tr>
           <tr>
           <td width="450"><?php echo "Message" ?>: <textarea class="form-control" name="message" rows="8" required="required"></textarea></td>
           </tr>
           <tr>
           <td>
           <button type="submit" class="btn btn-primary"><?php echo "Send Email" ?></button> 
           </td>
           </tr>
           </tbody>
          </table>
          </form>
  		</div>  
        <div class="panel panel-default midi-left2">
    	<div class="panel-heading"><strong><?php echo "Email Settings" ?> </strong></div>
        <div class='alert alert-info'>
       Type the username of the user you want to send email to in the To: field.
        </div>
          <table class="table">
           <tbody>
          <form method="post" action="<?php echo ISVIPI_URL.'conf/massMails/' ?>">
          <input type="hidden" name="action" value="singleMsg">
          <table>
           <tbody>
           <tr>
           <td><?php echo "To" ?>: <input type="text" class="form-control" name="to" value="" required="required"></td>
           </tr>
           <tr>
           <td><?php echo "Subject:" ?>
           <input type="text" class="form-control" name="subject" required="required"/> 
           </td>
           </tr>
           <tr>
           <td width="450"><?php echo "Message" ?>: <textarea class="form-control" name="message" rows="8" required="required"></textarea></td>
           </tr>
           <tr>
           <td>
           <button type="submit" class="btn btn-primary"><?php echo "Send Email" ?></button>
           </td>
           </tr>
           </tbody>
          </table>
          </form>
           </tbody>
           </table>
  		</div> 
     </div> 
<hr />
     	<div class="panel panel-default">
    	<div class="panel-heading"><strong><?php echo "Sent Emails" ?> </strong></div>
        <table class="table table-bordered">
          <thead>
          <tr>
          <th width="23%"><?php echo "Date" ?></th>
          <th width="15%"><?php echo "Sent To" ?></th>
           <th width="20%"><?php echo "Subject" ?></th>
           <th width="40%"><?php echo "Message" ?></th>
           </tr>
           </thead>
           <tbody>
           <?php getSentMessages();
		   while ($stmt->fetch()){
			getUserDetails($msgTO);
			$message = trunc_text($message, 20);   
			?>
           
           <tr>
           <td><?php echo date('d M Y \a\t g:ia', strtotime($timestamp)); ?></td>
           <td><?php echo $username ?></td>
           <td><?php echo $subject ?></td>
           <td><?php echo $message ?></td>
           </tr>
           <?php } ?>
           </tbody>
          </table>
  		</div>  
<div style="clear:both"></div>

     </div>
     </div><!--end of dash_cont_stat-->
     </div><!-- End of main_content-->
    </div> <!-- End of the container-->
    
   <!------////////////////////////
   <!-- Add Page Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo ADD_NEW_PAGE ?></h4>
      </div>
      <div class="modal-body">
      <div class='alert alert-info' style="width:560px;">
          <?php echo PARAG_PROMPT ?> 
          </div>
        <form method="post" action="<?php echo ISVIPI_URL.'conf/managePages/' ?>">
        <div class="form-group">
        <input type="text" class="form-control" name="p_title" placeholder="<?php echo TITLE ?>" required>
        </div>
        <div class="form-group">
        <textarea class="form-control" name="p_content" rows="10" placeholder="<?php echo TYPE_ANNOUNCE ?>" required="required"></textarea>
        </div>
        <input type="hidden" name="page" value="new_page">
        <button class="btn btn-primary" type="submit"><?php echo PUBLISH ?></button>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CLOSE ?></button>
      </div>
    </div>
  </div>
</div>
<?php include_once'footer.php';?>
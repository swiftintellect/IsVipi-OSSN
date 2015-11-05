<?php  
	require_once(ISVIPI_ADMIN_BASE .'ovr/head.php'); 
	require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ;
	require_once(ISVIPI_ADMIN_CLS_BASE .'get_members.cls.php');
	$members = new get_members();
?>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
		width : "100%",
		height: 250,
		statusbar : true,
		resize: "both"
     });
</script>
<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3>Emails</h3>
        </div>
        <div class="title_right">
    
    	</div>
    </div>
    <div class="clearfix"></div>
    <div class="row min-height"><!-- row -->
    
    	<div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Mass Emails</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/emailing' ?>" method="POST">
            	<p style="margin-left:10px;">Select the group of people you wish to email below.</p>
                <div class="col-md-12">
                	<select id="heard" class="form-control" name="type" required>
                    	<option value="all">All (<?php echo $members->total('all') ?>)</option>
                        <option value="active">Active (<?php echo $members->total('active') ?>)</option>
                        <option value="inactive">Inactive (<?php echo $members->total('inactive') ?>)</option>
                        <option value="suspended">Suspended (<?php echo $members->total('suspended') ?>)</option>
                        <option value="pending_deletion">Scheduled for Deletion (<?php echo $members->total('pending_deletion') ?>)</option>
                  	</select>
                </div>
                <div class="col-md-12">
               		<input type="text" name="subject" class="form-control" placeholder="Enter subject" required="required">
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group col-md-12">
                    <textarea name="msg" cols="5" class="form-control"></textarea>
                </div>
                <div class="col-md-12">
                <input type="hidden" name="aop" value="m_email" />
                <button type="submit" class="btn btn-success">Send Mass Email</button>
                </div>
            </form>
            
            </div>
            
        </div><!-- end::col-md-6 -->

    	
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Email an Individual</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/emailing' ?>" method="POST" enctype="multipart/form-data">
				<p style="margin-left:10px;">Enter an email to send a message to. It doesn't have to be a registered member.</p>
                <div class="col-md-12">
               		<input type="email" name="email" class="form-control" placeholder="Enter user email" required="required">
                </div>
                <div class="col-md-12">
               		<input type="text" name="subject" class="form-control" placeholder="Enter subject" required="required">
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group col-md-12">
                    <textarea name="msg" cols="5" class="form-control"></textarea>
                </div>
                <div class="col-md-12">
                <input type="hidden" name="aop" value="s_email" />
                <button type="submit" class="btn btn-success">Send Individual Email</button>
                </div>
            </form>
			</div>
            
		</div><!-- end::col-md-6 -->
        
        
        
        
        
        
        
	</div><!-- end::row -->

<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>
<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
    <section id="forgotPwd">
    	<div class="container">
            <div class="well col-md-6" style="padding:30px;">
            <legend><i class="fa fa-user-plus"></i> Change Password!</legend>
            <form action="<?php echo ISVIPI_URL .'p/users' ?>" method="post" class="form" role="form" id="regForm">
            	<div class="row">
                	<input class="form-control" name="pwd" placeholder="New Password*" type="password" autofocus required/>
                <br />
                	<input class="form-control" name="pwd2" placeholder="Repeat New Password*" type="password" autofocus/>
                </div>
                <hr />
                <div class="row">
                	<input type="hidden" name="isv_op" value="<?php echo $converter->encode('change') ?>" />
                    <button class="btn btn-lg btn-success btn-block" type="submit">Change Password</button>
            	</div>
            </form>
          </div>
          
          <div class="well col-sm-5 white-gradient" style="padding:10px; color:#000000; margin:0 10px">
          	<p><i class="fa fa-lightbulb-o"></i> Tips!</p>
            <ul>
            	<li>Make sure the new password is easy to remember but hard to guess.</li>
                <li>MINIMUM of 8 characters but the more the better.</li>
                <li>Mix letters, numbers and special characters (i.e.. -_@,;:)</li>
            
            </ul>
          </div>
        </div>
    </section><!--/#error-->
<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3>Credits</h3>
        </div>
        <div class="title_right">
    
    	</div>
    </div>
    <div class="clearfix"></div>
    <div class="row min-height"><!-- row -->
    	<div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel">
                <h3 class="cred_title">Founder & Project Manager</h3>
                <p>Jones Baraza</p>
        	</div>
            <div class="x_panel">
                <h3 class="cred_title">Tester</h3>
                <p>Martin Sundseth (Norway)</p>
            </div>
            <!--<div class="x_panel">
                <h3 class="cred_title">Hosting</h3>
                <p>We are grateful to <a href="">hoster</a> for allowing us to use their servers for free.</p>
            
            

			</div>-->
        </div><!-- end::col-md-6 -->
        
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel">
                <h3 class="cred_title">Frameworks</h3>
                <p>Bootstrap, FontAwesome, ionicframework, jQuery, AdminLTE, gentelella</p>
            </div>
            <div class="x_panel">
                <h3 class="cred_title">Plugins</h3>
                <p>tinymce, html5shiv, respond.min.js, jQuery Form Plugin (malsup), jquery.timer</p>
			</div>
        </div><!-- end::col-md-6 -->
        <div class="clearfix"></div>
        <hr />
        <div class="col-md-6">
        	<div class="x_panel">
            	<h3 class="edit_prof_h3">Donate</h3>
                <p>Is IsVipi OSSN doing a great job? Well, if you think it does, please consider making a donation. Your donations go a long way towards supporting the development of IsVipi OSSN.</p>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="margin-bottom:20px">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="ZMWP83F3ACBBC">
                <input type="hidden" name="on0" value="Donation Amount">
                <div class="col-md-5">
                <select name="os0" class="form-control">
                    <option value="10">$10.00 USD</option>
                    <option value="25">$25.00 USD</option>
                    <option value="50">$50.00 USD</option>
                    <option value="100">$100.00 USD</option>
                    <option value="250">$250.00 USD</option>
                    <option value="500">$500.00 USD</option>
                    <option value="1000">$1,000.00 USD</option>
                </select> 
                </div>
                <div class="col-md-7">
                <input type="submit" class="btn btn-primary" name="submit" alt="PayPal - The safer, easier way to pay online!" value="Make a Donation">
                </div>
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>

            </div>
        </div>
        
        <div class="col-md-6">
        	<div class="x_panel">
            	<h3 class="edit_prof_h3">Contribute</h3>
                <p>If you are a web developer and would like to help make IsVipi OSSN better, you can <a href="https://github.com/IsVipiOfficial/IsVipi-OSSN" target="_blank"><u>fork our project at github</u></a>.</p>
            </div>
        </div>
        
        
	</div><!-- end::row -->

<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>
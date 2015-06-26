<?php
/*/////////////////////////////////////
Plugin Name: test
Plugin URL: http://isvipi.org/test/
Description: This is a simple test plugin
Version: 1.0.0
Author: IsVipi_OSSN
Author URL: http://isvipi.org
//////////////////////////////////*/
	//Check if is logged in
	isLoggedIn();
	 $user = $_SESSION['user_id'];
	 getUserDetails($user);
	 pollUser($user);
	 base_header($site_title,$ACTION[0]);
	get_header()?>
    
    <!--If you need the sidebar menu then call it -->
		<?php get_sidebar()?>
        
	<!--This is the body-->
    <div class="something" style="width:400px; float:left !important;">
		<?php my_test_function() ?><br/><br/>
        
        <?php
		//We call the function that will retrieve data from our database
		get_test_DbData();
		?>
        Row ID: <?php echo htmlspecialchars($Testid) ?><br/>
        Field Two: <?php echo htmlspecialchars($Testtf1) ?><br/>
        Field Three: <?php echo htmlspecialchars($Testtf2) ?><br/>
        Field Four: <?php echo htmlspecialchars($Testtf3) ?><br/>
    </div>
    <!-- End of the body -->
    
    <!-- If you need the announcements panel then call it -->
		<?php get_r_sidebar()?>
        
    <!--Finally call the footer -->
<?php get_footer()?>
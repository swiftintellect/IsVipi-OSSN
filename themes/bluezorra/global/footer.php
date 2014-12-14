<?php if (!signedIn()){?>
<div class="footer">
	<!--menu items -->
    <div class="footer_links">
    <?php getAllPagesFront(); global $getAllP;global $p_title; global $p_id?>
    	<?php while($getAllP->fetch()){
			$sub = str_replace(" ", "_", $p_title);?>
            <li><a href="<?php echo ISVIPI_URL.'p/'.$sub.'-p'.$p_id.'#.'.rand(0, 9999) ?>"><?php echo $p_title ?></a></li>
		<?php }?>
    </div>
    <!-- copyright text PLEASE DO NOT CHANGE THIS COPYRIGHT TEXT -->
    <div class="copyright_text">
    	<?php footer_text()?>
    </div>
</div>
	<script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo ISVIPI_THEME_URL ?>style/js/jquery.amaran.min.js"></script>
       <script>
			$('#regForm').ajaxForm({ 
			target: '#notice', 
			success: function() { 
				$('#notice').fadeIn('slow'); 
				} 
			}); 
		</script>

<?php } else { ?>
	<div class="footer-home">
	<!--menu items -->
    <div class="footer_links">
    <?php getAllPagesFront(); global $getAllP;global $p_title; global $p_id?>
    	<?php while($getAllP->fetch()){
			$sub = str_replace(" ", "_", $p_title);?>
            <li><a href="<?php echo ISVIPI_URL.'p/'.$sub.'-p'.$p_id.'#.'.rand(0, 9999) ?>"><?php echo $p_title ?></a></li>
		<?php }?>
    </div>
    <!-- copyright text----
    --- PLEASE DO NOT CHANGE THIS COPYRIGHT TEXT -->
    <div class="copyright_text">
    	<?php footer_text()?>
    </div>

</div>
	<!-- if the user is signed in -->
	<script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo ISVIPI_THEME_URL ?>style/js/app.js"></script>
    <script type="text/javascript" src="<?php echo ISVIPI_THEME_URL ?>style/js/jquery.amaran.min.js"></script>
<?php } ?>

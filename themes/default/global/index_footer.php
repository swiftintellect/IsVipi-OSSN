<div class="row">
    <div class="index-footer">
    <div class="footer_menu_index">
     <?php getAllPagesFront(); global $getAllP;global $p_title; global $p_id?>
     <?php while($getAllP->fetch()){
     $sub = str_replace(" ", "_", $p_title);?>
    <li><a href="<?php echo ISVIPI_URL.'p/'.$sub.'-p'.$p_id.'#.'.rand(0, 9999) ?>"><?php echo $p_title ?></a> </li>
	<?php }?>
    </div>
     <p><?php footer_text()?></p>
    </div>
</div><!--end of row-->
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/jQuery_v2.1.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/ajax/form-submit.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/bootstrap.min.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/alertify.min.js"></script>
   <script>
    // bind form using ajaxForm 
    $('#regForm').ajaxForm({ 
        // target identifies the element(s) to update with the server response 
        target: '#notice', 
 
        // success identifies the function to invoke when the server response 
        // has been received; here we apply a fade-in effect to the new content 
        success: function() { 
            $('#notice').fadeIn('slow'); 
        } 
    }); 
</script>
    </body>
</html>
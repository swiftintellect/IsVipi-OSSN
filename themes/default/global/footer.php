<div class="row">
    <div class="footer">
    <div class="footer_menu_index">
     <?php getAllPagesFront(); global $getAllP;global $p_title; global $p_id?>
     <?php while($getAllP->fetch()){
     $sub = str_replace(" ", "_", $p_title);?>
    <li><a href="<?php echo ISVIPI_URL.'p/'.$sub.'-p'.$p_id.'#.'.rand(0, 9999) ?>"><?php echo $p_title ?></a></li>
	<?php }?>
    </div>
     <p><?php footer_text()?></p>
    </div>
</div><!--end of row-->
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/bootstrap.min.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/alertify.min.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/idle.min.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/ajax/form-submit.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/jquery.fs.boxer.min.js"></script>
<script type="text/javascript">
setIdleTimeout(1800000);
document.onIdle = function() {window.location = "<?php echo ISVIPI_URL. 'session_expire'?>";}
</script>
</body>
</html>
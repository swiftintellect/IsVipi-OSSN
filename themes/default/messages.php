<?php get_header()?>
<?php get_sidebar()?>
                       <div class="dash_content">
                        <div class="panel panel-primary">
                          <div class="panel-heading"><?php echo MY_CONV ?>
                           </div>
                               <div class="panel-body members_full">
                                     <div class="m_list">
                                        <div class="scrollable2">
                                        <div id="msgRefr">
                                        <center>
                                        <div id="msgsLoading">
                            				<img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
                            			</div>
                                        </center>

                                     </div>
                                     </div>
                                  </div>
							  </div>
                          </div><!--end of panel-->
                        </div><!--end of dash_content-->
<script>
$(document).ready(function() {
	$('#msgRefr').load(fullURL+"/remote/msgs/");
    $('#msgRefr').timer({
		delay: 3000,
		repeat: true,
		url: fullURL+"/remote/msgs/"
	});
}); 
</script> 
<?php get_r_sidebar()?>
<?php get_footer()?>
<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
<?php $pageManager->loadsideBar('sidebar'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
        	<!-- message list -->
        	<section class="col-lg-4">
				<div class="box box-solid members">
                	<div class="box box-solid">
                        <div class="box-header with-border">
                          <h3 class="box-title">Inbox</h3>
                        </div>
                        <script>
							function load_chat_sidebar($username){
								$("#msg_users").load(site_url +'/chat_sidebar/' +$username);
								$("#msg_users").timer({
									delay: 30000, //poll every 30 sec (30000)
									repeat: true,
									url: site_url +'/chat_sidebar/' +$username
								});
							}
						</script>
                        

                        <div class="box-body no-padding" id="msg_users">
                            <script>
								load_chat_sidebar('<?php echo $user_name ?>');
							</script>
                        </div><!-- /.box-body -->
                      </div><!-- /. box -->
                </div>
            <div class="clear"></div> 
			</section>
            <!--end::message list -->
			
            
            <!-- chat -->
            <section class="col-lg-8">
            	<?php if(empty($user_name) || $user_name === ''){ ?>
					<div class="box box-primary">
                        <div class="box-header with-border">
                        </div>
                        <div class="box-body no-padding">
                            <div class="box-footer">
                                You do not have any chat selected
                            </div>
                        </div>
                    </div>
				<?php } else { ?>
                <script>
					function load_chat($user){
						$("#load_chat").load(site_url +'/chat/'+$user);
						$("#load_chat").timer({
							delay: 30000, //poll every 30 sec (30000)
							repeat: true,
							url: site_url +'/chat/'+$user
						});
					}
				</script>
            	<div class="box box-primary" id="load_chat">
                	<script>
						load_chat('<?php echo $user_name ?>');
					</script>
                </div>
                <?php
					if(id_from_username($user_name))
				?>
                <div class="box-footer" style="margin-top:-20px;">
                	<form action="<?php echo ISVIPI_URL .'p/messaging' ?>" method="post" id="addMessage">
                  		<div class="input-group">
                       	<input type="text" name="msg" placeholder="Type Message ..." class="form-control">
                       		<span class="input-group-btn">
                            <input type="hidden" name="to" value="<?php echo $converter->encode($user_id) ?>" />
                            <input type="hidden" name="isv_op" value="send_pm" />
                          	<button type="submit" class="btn btn-warning btn-flat">Send</button>
                          	</span>
                    	</div>
                 	</form>
           		</div><!-- /.box-footer-->
                      <script>
						$('#addMessage').ajaxForm({ 
							success: function() { 
								setTimeout(function(){
									$('#addMessage').clearForm();
									load_chat('<?php echo $user_name ?>');
								}, 3000);
							 } 
							});
						</script>

                <?php } ?>
            
            
            </section>
            <!-- end::chat -->
            
            <div class="clear"></div>
            </section>
        </section>
        <!-- /.content -->
        
      </div>
      <!-- /.content-wrapper -->
      
<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>

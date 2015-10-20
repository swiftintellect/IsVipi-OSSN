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
							function load_chat_sidebar(){
								$("#msg_users").load(site_url +'/chat_sidebar/<?php echo $username ?>');
								$("#msg_users").timer({
									delay: 30000, //poll every 30 sec (30000)
									repeat: true,
									url: site_url +'/chat_sidebar/'
								});
							}
						</script>
                        <div class="box-body no-padding" id="msg_users">
                            <script>
								load_chat_sidebar();
							</script>
                        </div><!-- /.box-body -->
                      </div><!-- /. box -->
                      
                </div>
            <div class="clear"></div> 
			</section>
            <!--end::message list -->
			
            
            <!-- chat -->
            <section class="col-lg-8">
            	<?php if(empty($username) || $username === ''){ ?>
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
            	<div class="box box-primary" id="load_chat">
                	<?php require_once(ISVIPI_ACT_THEME .'pages/chat.php') ?>
                </div>
                <div class="box-footer">
                	<form action="#" method="post">
                  		<div class="input-group">
                       	<input type="text" name="message" placeholder="Type Message ..." class="form-control">
                       		<span class="input-group-btn">
                          	<button type="button" class="btn btn-warning btn-flat">Send</button>
                          	</span>
                    	</div>
                 	</form>
           		</div><!-- /.box-footer-->
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

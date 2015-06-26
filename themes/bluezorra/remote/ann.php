             <!--------------------------------
                 ----- ANNOUNCEMENTS & ADS --------
                 --------------------------------->
                 <?php getAnnouncements();
					global $getAnn,$ann_id,$ann_date,$ann_subject,$ann_content;
				 ?>
                 <div class="after-feeds"><!-- after-feeds -->
                 	<div class="row"><!-- row -->
                        <div class="col-md-12">
                            <div class="box box-solid">
                           
                            	<div class="box-header">
                                    <h4 class="box-title"><?php echo ANNOUNCEMENTS ?></h4>
                                </div>
                                <hr class="no-margin"/>
                                <?php 
									while ($getAnn->fetch() )
										{
											$subject = trunc_text($ann_subject, 5);
											$announc = trunc_text($ann_content, 20);
									?>
                                <div class="box-body">
                                <?php
								global $site_url;
								$sub = str_replace(" ", "_", $ann_subject);
								?>
                                    
                                <div class="ann_title">
                                <a href="<?php echo $site_url.'/p/'.$sub.'-p'.$ann_id.'#.'.rand(0, 9999) ?>" ><?php echo $ann_subject ?></a>
                                </div>
                                	<!-- announcement date -->
                                    <div class="announcement_date">
                                    <?php echo $ann_date ?>
                                    </div>
                                    
                                    <!-- announcement excerpt -->
                                    	<?php echo makeLinks($announc)?>
                                    
                                    <hr class="no-margin"/>
                                </div><!-- /.box-body -->
                                
                                <?php } ?>
                            </div><!-- /.box -->
                        </div><!-- ./col -->
                     </div><!-- ./row -->
                 </div><!--./ after-feeds -->

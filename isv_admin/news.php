<?php  
	require_once(ISVIPI_ADMIN_BASE .'ovr/head.php'); 
	require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ;
	require_once(ISVIPI_CLASSES_BASE .'global/get_news_cls.php');
	$news = new news();
	$news_count = $news->get_news_count('all');
	$all_news = $news->get_all_news('all');
?>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
		width : "100%",
		height: 250,
		statusbar : true,
		resize: "both"
     });
</script>
<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3>Site News & Announcements</h3>
        </div>
        <div class="title_right">
    
    	</div>
    </div>
    <div class="clearfix"></div>
    <div class="row min-height"><!-- row -->
    
    	<div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Compose new News Item</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/news' ?>" method="POST">
                <div class="col-md-12">
               		<input type="text" name="title" class="form-control" placeholder="Enter news title" required="required">
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group col-md-12">
                    <textarea name="news" cols="5" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <div class="col-md-1 col-sm-9 col-xs-12">
                        <input type="checkbox" value="1" name="status">
                    </div>
                    <div class="col-md-11 col-sm-3 col-xs-12">
                    	<label class="control-label">Check this box to publish the news item once you click save.</label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr />
                <div class="col-md-12">
                <input type="hidden" name="aop" value="new_news" />
                <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
            
            </div>
            
        </div><!-- end::col-md-6 -->

    	
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">News Items (<?php echo $news_count ?>)</h3>
            <p style="margin-left:10px;">Click on the news item title to preview it.</p>
			<table class="table table-striped responsive-utilities jambo_table">
            	<thead>
                	<tr class="headings">
                    	<th class="column-title"># </th>
                        <th class="column-title">Title</th>
                        <th class="column-title">Status</th>
                        <th class="column-title">Actions</th>
                    </tr>
            	</thead>
                <tbody>
                <?php if($news_count > 0){?>
                <?php if(is_array($all_news)) foreach ($all_news as $key => $n) {
					if($n['status'] == '0'){
						$status = '<span class="label label-danger"><i class="fa fa-times"></i></span>';
					} else {
						$status = '<span class="label label-success"><i class="fa fa-check"></i></span>';
					}
				?>
                	<tr class="even pointer">
                    	<td class=""><?php echo $n['id'] ?></td>
                        <td class="">
                            <a href="#" data-toggle="modal" data-target="#view<?php echo $n['id'] ?>">
                                <?php echo truncate_($n['title'], 5) ?>
                            </a>
                        </td>
                        <td class=""><?php echo $status ?></td>
                        <td class="">
                        	<?php if($n['status'] == '0'){?>
                        		<a href="<?php echo ISVIPI_URL.'aa/news/'.$converter->encode('publish').'/'.$converter->encode($n['id']) ?>" class="btn btn-success btn-sm2">publish</a> 
                            <?php } else {?>
                            	<a href="<?php echo ISVIPI_URL.'aa/news/'.$converter->encode('unpublish').'/'.$converter->encode($n['id']) ?>" class="btn btn-warning btn-sm2">unpublish</a> 
                            <?php } ?>
                            <a class="btn btn-primary btn-sm2" data-toggle="modal" data-target="#edit<?php echo $n['id'] ?>">edit</a> 
                            <a href="" class="btn btn-danger btn-sm2" data-toggle="modal" data-target="#del<?php echo $n['id'] ?>">delete</a>
                        </td>
                	</tr>
            <!-- preview modal -->
            <div class="modal fade" id="view<?php echo $n['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header modal-h">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $n['title'] ?> </h4>
                  </div>
                  <div class="modal-body">
                    <ul class="list-group">
                      <li class="list-group-item">Title: <strong><?php echo $n['title'] ?></strong></li>
                      <li class="list-group-item">Date Published: <strong><?php echo $n['pub_date'] ?></strong></li>
                      <li class="list-group-item"><?php echo $n['news'] ?></li>
                    </ul>
                    
                  </div>
                  <div class="modal-footer modal-h">
                    <a href="#" class="btn btn-default" data-dismiss="modal" style="margin-top:5px;">Cancel</a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- edit modal -->
            <div class="modal fade" id="edit<?php echo $n['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header modal-h">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $n['title'] ?> </h4>
                  </div>
                  <div class="modal-body">
					<form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/news' ?>" method="POST">
                    <div class="col-md-12">
                        <input type="text" name="title" class="form-control" value="<?php echo $n['title'] ?>" required="required">
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator"></div>
                    <div class="form-group col-md-12">
                        <textarea name="news" cols="5" class="form-control"><?php echo $n['news'] ?></textarea>
                    </div>
                    <div class="col-md-12">
                    <input type="hidden" name="news_id" value="<?php echo $converter->encode($n['id']) ?>" />
                    <input type="hidden" name="aop" value="edit_news" />
                    <button type="submit" class="btn btn-success">Save</button>
                    
                    <a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
                    </div>
                </form>
                    
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            
            <!-- Delete news item modal -->
            <div class="modal fade" id="del<?php echo $n['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header modal-h">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete <strong><?php echo $n['title'] ?></strong> </h4>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete this news item?</strong>
                  </div>
                  <div class="modal-footer modal-h">
                    <a href="#" class="btn btn-default" data-dismiss="modal" style="margin-top:5px;">Cancel</a>
                    <a href="<?php echo ISVIPI_URL.'aa/news/'.$converter->encode('delete').'/'.$converter->encode($n['id']) ?>" class="btn btn-primary">Yes, Delete Item</a>
                  </div>
                </div>
              </div>
            </div>
				
				
				
				<?php } ?>
                <?php } else { ?>
                	<tr class="even pointer">
                    	<td class="">No news item found</td>
                        <td class="">-</td>
                        <td class="">-</td>
                        <td class="">-</td>
                	</tr>
                <?php } ?>
                </tbody>
            </table>
			</div>
            
		</div><!-- end::col-md-6 -->
        
        
        
        
        
        
        
	</div><!-- end::row -->

<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>
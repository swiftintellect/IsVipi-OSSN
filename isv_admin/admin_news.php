<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_CLASSES_BASE .'global/get_news_cls.php');
	$news = new news();
	$news_count = $news->get_news_count('all');
	$all_news = $news->get_all_news('all');
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            News & Announcements
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">News & Announcements</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
            	<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Compose new News Item</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/news' ?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="news title">News Title</label>
                      <input type="text" name="title" class="form-control" placeholder="Enter news title" required="required">
                    </div>
                    <div class="form-group">
                      <label for="news">News</label>
                      <textarea name="news" rows="10" class="form-control" id="editor"></textarea>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="status"> Check this box to publish the news item once you click save.
                      </label>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('new_news') ?>" />
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>
            
            
            <div class="col-md-6">
            	<div class="box box-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">News Items (<?php echo $news_count ?>)</h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
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
                                            <a href="<?php echo ISVIPI_URL.'aa/news/'.$converter->encode('publish').'/'.$converter->encode($n['id']) ?>" class="btn btn-success btn-xs">publish</a> 
                                        <?php } else {?>
                                            <a href="<?php echo ISVIPI_URL.'aa/news/'.$converter->encode('unpublish').'/'.$converter->encode($n['id']) ?>" class="btn btn-warning btn-xs">unpublish</a> 
                                        <?php } ?>
                                        <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit<?php echo $n['id'] ?>">edit</a> 
                                        <a href="" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#del<?php echo $n['id'] ?>">delete</a>
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
                                      <ul class="products-list product-list-in-box">
                                          <li class="item">
                                          <div class="">
                                            <?php echo $n['title'] ?> <span class="pull-right"><?php echo $n['pub_date'] ?></span>
                            				<hr style="margin:5px 0" />
                                            <div style="background:#E6E6E6; padding:10px; width:100%;">
                                              <?php echo $n['news'] ?>
                                            </div>
                                          </div>
                                        </li><!-- /.item -->
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
                                      
                                        <form action="<?php echo ISVIPI_URL .'aa/news' ?>" method="POST">
                                        <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" name="title" class="form-control" value="<?php echo $n['title'] ?>" required="required">
                                        </div>
                                        <div class="form-group">
                                        	<textarea name="news" rows="10" class="form-control" id="editor<?php echo $n['id'] ?>"><?php echo $n['news'] ?></textarea>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                        <input type="hidden" name="news_id" value="<?php echo $converter->encode($n['id']) ?>" />
                                        <input type="hidden" name="aop" value="<?php echo $converter->encode('edit_news') ?>" />
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
                                <script>
									$(function () {
									CKEDITOR.replace('editor<?php echo $n['id'] ?>', {
										toolbar :
										[
											{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ] },
											{ name: 'paragraph', items : [ 'NumberedList','BulletedList' ] },
											{ name: 'tools', items : [ 'Maximize','-' ] }
										]
									});
								  });
							  </script>
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
                    </div><!-- /.box-body -->
               </div><!-- /.box -->
            <div class="clearfix"></div>
            </div>
        

		<div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>
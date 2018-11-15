<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_CLASSES_BASE .'banners/class.banner.php');
	$banner = new banner();
	$bannercount = $banner->banner_count();
	$banners = $banner->get_all_banners();
 ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Advertisements 
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Advertisements</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
            	<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add new Advertisement Banner</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo ISVIPI_URL .'aa/banner' ?>" method="POST" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="banner link">Banner Link (leave blank if not required)</label>
                      <input type="text" name="link" class="form-control" placeholder="Banner link e.g. http://isvipi.org">
                      <span style="font-size:12px; color:#575757">The banner link will be used to redirect the user to that link when the banner is clicked.</span>
                    </div>
                    <div class="form-group">
                      <label for="Upload Banner">Select Banner</label>
                      <input type="file" name="banner" class="form-control" />
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="1" name="ntab"> Open Link in New Tab
                      </label>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	<input type="hidden" name="aop" value="<?php echo $converter->encode('new') ?>" />
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div>
            
            <div class="col-md-6">
            	<div class="box box-warning">
                	<div class="box-header with-border">
                          <h3 class="box-title">Banners</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    	<table class="table table-striped responsive-utilities jambo_table">
                        	<thead>
                                <tr class="headings">
                                    <th class="column-title"># </th>
                                    <th class="column-title">Link</th>
                                    <th class="column-title">Banner</th>
                                    <th class="column-title">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            	<?php if($bannercount > 0 && is_array($banners)){
									foreach($banners as $key => $bn){
								?>
                            	<tr class="even pointer">
                                	<td class=""><?php echo $bn['id'] ?></td>
                                    <td class=""><?php echo $bn['link'] ?></td>
                                    <td class="bn-img">
                                    	<img src="<?php echo ad_banner($bn['banner']) ?>" />
                                    </td>
                                    <td class="">
                                    	<a href="<?php echo ISVIPI_URL.'aa/banner/'.$converter->encode('delete').'/'.$converter->encode($bn['id']) ?>">Delete</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr class="even pointer">
                                	<td class="">No entries found</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    
                    </div>
                
                </div>
            
            </div>

        <div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php'); 
	$pageManager = new pageManager();
	$s_m = $pageManager->siteMeta();
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Display Settings
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Display Settings</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-6">
            	<div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Select Theme</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                      <!--scan the themes directory for themes -->
                      <div class="box-body">
                      <?php
						$themes = array_diff(scandir(ISVIPI_THEMES), array('..', '.'));
						foreach($themes as $theme){?>
                          <div class="col-md-6">
                          	<!-- check is a screenshot of the theme is available -->
                            <div class="theme_title"><?php echo $theme ?></div>
                            <?php if(file_exists(ISVIPI_THEMES.$theme.'/screen.png')){?>
                            	<img src="<?php echo ISVIPI_THEMES_URL.$theme.'/screen.png' ?>" alt="<?php echo $theme ?>" class="screenshot">
                            <?php } else {?>
                            	<img src="http://placehold.it/150x100" alt="<?php echo $theme ?>" class="screenshot">
                            <?php } ?>
                            <hr style="margin:5px 0" />
                            <?php if($isv_siteDetails['s_theme'] == $theme){?>
                            	<button class="btn btn-warning btn-xs btn-block disabled">Currently Default</button>
                            <?php } else {?>
                            	<a href="<?php echo ISVIPI_URL .'aa/s_general/'.$converter->encode('c_theme').'/'.$converter->encode($theme) ?>" class="btn btn-success btn-xs">Make Default</a>
                            	<a href="<?php echo ISVIPI_URL .'aa/s_general/'.$converter->encode('theme_del').'/'.$converter->encode($theme) ?>" class="btn btn-danger btn-xs">Delete</a>
                            <?php } ?>
                          </div>
                        <?php } ?>
                        </div><!-- /.box-body -->
                  </div><!-- /.box -->
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Select Logo</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST" enctype="multipart/form-data">
                      <div class="box-body">
                      	<div class="col-md-4">
                        	<img src="<?php echo ISVIPI_STYLE_URL . 'site/imgs/'.$isv_siteSettings['logo'] ?>" class="logo_bg">
                        </div>
                      	<div class="col-md-8">
                            <input type="file" class="form-control" name="logo_img" required="required">
                            <div class="text-blue">recommended 150px x 60px (.png)</div>
                        </div>
                      
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <input type="hidden" name="aop" value="<?php echo $converter->encode('logo') ?>" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </form>
                  </div><!-- /.box -->
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Select Favicon</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST" enctype="multipart/form-data">
                      <div class="box-body">
                      	<div class="col-md-4">
                        	<img src="<?php echo ISVIPI_STYLE_URL .'site/imgs/'.$isv_siteSettings['favicon']?>">
                        </div>
                      	<div class="col-md-8">
                            <input type="file" class="form-control" name="fav_icon" required="required">
                        	<div class="text-blue">recommended 64px x 64px or 32px x 32px</div>
                        </div>
                      
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <input type="hidden" name="aop" value="<?php echo $converter->encode('favicon') ?>" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </form>
                  </div><!-- /.box -->
                  <div class="clearfix"></div>


                </div>
            
                <div class="col-md-6">
                	<div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">Meta Keywords</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
                      <div class="box-body">
                      	<div class="form-group">
                          <label for="site email">Meta Keyword</label>
                          <textarea name="keywords" rows="5" class="form-control"><?php echo $s_m['meta_tags'] ?></textarea>
                          <p>What words/phrases can be used to find your site on a search engine like google? Separate each word/phrase with a coma.</p>
                        </div>
                      
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <input type="hidden" name="aop" value="<?php echo $converter->encode('key_w') ?>" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </form>
                  </div><!-- /.box -->
                  
                  <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">Meta Description</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
                      <div class="box-body">
                      	<div class="form-group">
                          <label for="site email">Meta Description</label>
                          <textarea name="description" rows="5" class="form-control"><?php echo $s_m['meta_descr']; ?></textarea>
                          <p>Brief, one sentence description of your site.</p>
                        </div>
                      
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <input type="hidden" name="aop" value="<?php echo $converter->encode('m_descr') ?>" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </form>
                  </div><!-- /.box -->
                
                </div>
                <div class="clearfix"></div>
            
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>
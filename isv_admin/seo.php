<?php  
	require_once(ISVIPI_ADMIN_BASE .'ovr/head.php'); 
	require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ;
	global $isv_siteDetails,$isv_siteSettings;
	
	$pageManager = new pageManager();
	$s_m = $pageManager->siteMeta();
	
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3>SEO Settings</h3>
        </div>
        <div class="title_right">
    
    	</div>
    </div>
    <div class="clearfix"></div>
    <div class="row min-height"><!-- row -->
    
    	<div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Meta Keywords</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
            	<p style="margin-left:10px;">What words/phrases can be used to find your site on a search engine like google? Separate each word/phrase with a coma</p>
                <div class="form-group col-md-12">
                    <textarea name="keywords" cols="5" class="form-control"><?php echo $s_m['meta_tags'] ?></textarea>
                </div>
                <div class="form-group">
                <input type="hidden" name="aop" value="key_w" />
                <button type="submit" class="btn btn-success">Save Meta Keywords</button>
                </div>
            </form>
            
            </div>
            
            <div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Meta Description</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST">
			<p style="margin-left:10px;">Brief, one sentence description of your site.</p>
                <div class="form-group col-md-12">
                    <textarea name="description" cols="5" class="form-control"><?php echo $s_m['meta_descr']; ?></textarea>
                </div>
                <div class="form-group">
                <input type="hidden" name="aop" value="m_descr" />
                <button type="submit" class="btn btn-success">Save Meta Description</button>
                </div>            </form>
            </div>
        </div><!-- end::col-md-6 -->

    	
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Change Logo</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST" enctype="multipart/form-data">
            	<div class="form-group">
                    <div class="col-md-4 col-sm-3 col-xs-12">
                        <div class="seo-logo">
                        	<img src="<?php echo ISVIPI_STYLE_URL . 'site/imgs/'.$isv_siteSettings['logo'] ?>" alt="..." />
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="file" class="form-control" name="logo_img" required="required">
                        <div class="adm-uri">recommended 150px x 60px</div>
                    </div>
                </div>
                
                <div class="form-group col-md-12">
                <input type="hidden" name="aop" value="logo" />
                <button type="submit" class="btn btn-success">Upload</button>
                </div>
                </form>
			</div>
            
            <div class="x_panel min-edt-h2">
          	<h3 class="edit_prof_h3">Change favicon</h3>
            <form class="edt-prf2" action="<?php echo ISVIPI_URL .'aa/s_general' ?>" method="POST" enctype="multipart/form-data">
            	<div class="form-group">
                    <div class="col-md-4 col-sm-3 col-xs-12">
                        <div class="seo-favicon">
                        	<img src="<?php echo ISVIPI_STYLE_URL .'site/imgs/'.$isv_siteSettings['favicon']?>" alt="..." />
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <input type="file" class="form-control" name="fav_icon" required="required">
                        <div class="adm-uri">recommended 64px x 64px or 32px x 32px</div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="separator"></div>
                <div class="form-group col-md-12">
                <input type="hidden" name="aop" value="favicon" />
                <button type="submit" class="btn btn-success">Save Status</button>
                </div>
                </form>
			</div>
		</div><!-- end::col-md-6 -->
        
        
        
        
        
        
        
	</div><!-- end::row -->

<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>
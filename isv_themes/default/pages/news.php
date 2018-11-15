<?php
	require_once(ISVIPI_CLASSES_BASE .'global/get_news_cls.php');
	$news = new news();
	$news_count = $news->get_news_count('1');
	$all_news = $news->get_sidebar_news('1');
	if($news_count > 0){
		if(is_array($all_news)) foreach ($all_news as $key => $n) {
?>
<div class="box box-widget" style="padding:5px;margin-top:-20px;">
	<div class='box-header' style="padding:5px;">
    	<div class='user-block' style="border-bottom:solid thin #F4F4F4">
        	<div class='username' style="display:block; font-size:14px">
            	<a href="<?php echo ISVIPI_URL.'news/'.$converter->encode($n['id']); ?>"><?php echo truncate_($n['title'], 5) ?></a>
            </div>
       		<span class='description' style="font-size:12px"><?php echo UTC2Local($n['pub_date']) ?></span>
     	</div><!-- /.user-block -->
    </div>
    
    <div class='box-body' style="padding:5px;">
    	<?php echo truncate_(html_entity_decode ($n['news']), 25)?>
    </div>
</div>
	<?php } ?>
<?php } else { ?>
	<hr>
    No announcement or news has been published.
<?php } ?>

<?php
	require_once(ISVIPI_CLASSES_BASE .'banners/class.banner.php');
	$banner = new banner();
	$bann = $banner->get_banner();
	if(empty($bann['link'])){
		$link = "#";
	} else {
		$link = html_entity_decode($bann['link']);
	}
?>
<div class="image-ad">
	<a href="<?php echo $link ?>" <?php if(!empty($bann['ntab']) && $bann['ntab'] == 1){?>target="_blank"<?php } ?>>
		<img src="<?php echo ad_banner($bann['banner']) ?>" title="Ad Banner"/>
    </a>
</div>
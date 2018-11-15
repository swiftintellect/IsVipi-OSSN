<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php 
	$pageManager->loadCustomHeader('g_header','m_header'); 
	require_once(ISVIPI_CLASSES_BASE .'staticpages/class.staticpages.php');
	$sp = new staticpage();
	$content = $sp->get_static_page('aboutus');
?>
    <section class="page_content well">
		<h2 class="title">About Us</h2>
        <?php echo html_entity_decode($content) ?>
    </section><!--/#error-->
<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>
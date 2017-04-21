<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
    <section id="error404" class="text-center">
    	<div class="container">
        <h1>404, Page not found</h1>
        <p>The Page you are looking for does not exist or an error occured while processing your request.</p>
        <a class="btn btn-primary" href="<?php echo ISVIPI_URL ?>">GO BACK TO THE HOMEPAGE</a>
        </div>
    </section><!--/#error-->
<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>
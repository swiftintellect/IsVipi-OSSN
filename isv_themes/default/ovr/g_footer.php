    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                	<?php footerCopyright() ?>
                </div>
                <?php if(isset($pages) && $page === 'footer_pages'){?>
                <div class="col-sm-6">
                    <ul class="pull-right">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Faq</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
    </footer><!--/#footer-->
    <script src="<?php echo ISVIPI_STYLE_URL . 'default/js/bootstrap.min.js' ?>"></script>
</body>
</html>
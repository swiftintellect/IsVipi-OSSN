      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- Default to the left -->
        <?php footerCopyright() ?>
      </footer>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    <script src="<?php echo ISVIPI_STYLE_URL . 'default/js/bootstrap.min.js' ?>"></script>
    <script src="<?php echo ISVIPI_STYLE_URL . 'default/js/app.min.js' ?>"></script>
    <script>
		$('#notifications').on('click mouseover', function () {
			$('#notifications').timer('stop');
		});
		$('.content-wrapper').on('click', function () {
			$('#notifications').timer('start');
		});
	</script>

  </body>
</html>

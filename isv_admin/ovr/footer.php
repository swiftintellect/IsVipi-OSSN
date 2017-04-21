  <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          V. <?php echo ISV_VERSION ?>
        </div>
        <!-- Default to the left -->
        <?php footerCopyright() ?>
      </footer>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    <!-- Bootstrap -->
    <script src="<?php echo ISVIPI_STYLE_URL . 'default/js/bootstrap.min.js' ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo ISVIPI_ADMIN_URL .'style/js/app.min.js' ?>"></script>
    
    <!-- load the bootstrap ckeditor editor on select pages -->
    <?php if($PAGE[1] == "admin_news" || $PAGE[1] == "admin_emails"){ ?>
    	<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
        <script>
		  $(function () {
			CKEDITOR.replace('editor', {
				toolbar :
				[
					{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ] },
					{ name: 'paragraph', items : [ 'NumberedList','BulletedList' ] },
					{ name: 'tools', items : [ 'Maximize','-' ] }
				]
			});
		  });
		  
		  <?php if($PAGE[1] == "admin_emails"){?>
		  $(function () {
			CKEDITOR.replace('editor2', {
				toolbar :
				[
					{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ] },
					{ name: 'paragraph', items : [ 'NumberedList','BulletedList' ] },
					{ name: 'tools', items : [ 'Maximize','-' ] }
				]
			});
		  });
		  <?php } ?>
		  
		</script>
    <?php } ?>
    <?php if($PAGE[1] == "dashboard"){ ?>
    	<script src="<?php echo ISVIPI_ADMIN_URL .'style/js/plugins/chartjs/Chart.min.js' ?>"></script>
    <script>
	//-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
  var pieChart = new Chart(pieChartCanvas);
  var PieData = [
    {
      value: '<?php echo $feed['all_feeds'] ?>',
      color: "#f56954",
      highlight: "#f56954",
      label: "Feeds"
    },
    {
      value: '<?php echo $feed['all_likes'] ?>',
      color: "#00a65a",
      highlight: "#00a65a",
      label: "Likes"
    },
    {
      value: '<?php echo $feed['all_comments'] ?>',
      color: "#f39c12",
      highlight: "#f39c12",
      label: "Comments"
    },
    {
      value: '<?php echo $feed['all_shares'] ?>',
      color: "#00c0ef",
      highlight: "#00c0ef",
      label: "Shares"
    },
    {
      value: '<?php echo $feed['all_comm_likes'] ?>',
      color: "#3c8dbc",
      highlight: "#3c8dbc",
      label: "Comment Likes"
    },
  ];
  var pieOptions = {
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke: true,
    //String - The colour of each segment stroke
    segmentStrokeColor: "#fff",
    //Number - The width of each segment stroke
    segmentStrokeWidth: 1,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps: 100,
    //String - Animation easing effect
    animationEasing: "easeOutBounce",
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate: true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,
    //String - A legend template
    //String - A tooltip template
    tooltipTemplate: "<%=value %> <%=label%>"
  };
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  //-----------------
  //- END PIE CHART -
  //-----------------
  </script>
  <?php } ?>
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
  </body>
</html>

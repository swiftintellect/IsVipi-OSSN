   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/bootstrap.min.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/ajax/form-submit.js"></script>
   <script>
        $(document).ready(function() { 
            $('#shareUpdate').ajaxForm(function() { 
			$("#workingGenPost").show();
			setTimeout(function(){
			$("#sharedBox").hide();
			$("#sharedBoxAfter").fadeIn('slow');
			}, 2000);
			LoadTimeline();
            }); 
        }); 
	</script>
</body>

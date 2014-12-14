<?php
//Include the default admin header
include_once(ISVIPI_ADMIN_BASE.'header.php');
//Include the default admin sidebar menu
include_once(ISVIPI_ADMIN_BASE.'sidebar.php');
?>
<?php
///////////////////////////////////
///// USEFUL VARIABLES ///////////
// Your plugin name = $ACTION[2]
// Site URL = ISVIPI_URL
// HyperLink to your plugin sett = <a href="<?php echo ISVIPI_URL."settings/addon/".$ACTION[2]."/settings/" endPhpTag>Link</a>
// HyperLink to your plugin help = <a href="<?php echo ISVIPI_URL."settings/addon/".$ACTION[2]."/help/" endPhpTag>Link</a>
// replace endPhpTag with normal php end tag, like the one at the bottom of this page

//////// NOTE THE FOLLOWING STYLING INFO////
// 1. The margin-top styling attribute must be 65px and above
// 2. The margin-left styling attribute must be 240px and above
// 3. The div padding must be 20px and above

// This will immensely help reduce styling problems where some text could be hidden behind another DIV
?>
<div style="border:solid thin #00F; min-height:400px; background:#FFF; margin-top:65px; width:80%; margin-left:240px;padding:20px">
<h2 style="margin:5px;">My Plugin Settings Page</h2>
<div class="well">
<h3>You can make use of Bootstrap 3 elements and FonteAwesome here since the styles have already been loaded <i class="fa fa-smile-o"></i></h3>
<p>
You can place your addon settings here. All Bootstrap 3 elements are supported. This makes styling far much easier and fun.
<div class="form-group">
<input type="text" class="form-control" placeholder="see how easy it is?" />
</div>
<div class="form-group">
<textarea class="form-control" placeholder="I told you so :-)"></textarea>
</div>
<div class="form-group">
<button type="submit" class="btn btn-info">Button</button>
<button type="submit" class="btn btn-success">Button</button>
<button type="submit" class="btn btn-primary">Button</button>
<button type="submit" class="btn btn-info btn-lg">Button</button>
<button type="submit" class="btn btn-info btn-sm">Button</button>
</div>
</p>
</div>


<div class="alert alert-info">
Remember to create a help file that will tell the user how to install and use your plugin/mod. <a href="<?php echo ISVIPI_URL."settings/addon/".$ACTION[2]."/help/"?>">This</a> is an example of how you can link to the file. Or check out the ones under a h3 tag below.
</div>
<h3><a href="<?php echo ISVIPI_URL."settings/addon/".$ACTION[2]."/help/"?>">Help/Usage</a></h3>
<h3><a href="<?php echo ISVIPI_URL."settings/addon/".$ACTION[2]."/help/"?>">How to use this plugin/mod</a></h3>
</div>

<?php 
include_once(ISVIPI_ADMIN_BASE.'footer.php');
?>
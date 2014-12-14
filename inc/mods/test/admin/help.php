<?php
//Include the default admin header
include_once(ISVIPI_ADMIN_BASE.'header.php');
//Include the default admin sidebar menu
include_once(ISVIPI_ADMIN_BASE.'sidebar.php');
?>
<?php
//////// NOTE THE FOLLOWING ////
// 1. The margin-top styling attribute must be 65px and above
// 2. The margin-left styling attribute must be 240px and above
// 3. The div padding must be 20px and above

// This will immensely help reduce styling problems where some text could be hidden behind another DIV
?>
<div style="border:solid thin #00F; min-height:400px; background:#FFF; margin-top:65px; width:80%; margin-left:240px;padding:20px">
<h2 style="margin:5px;">Help</h2>
<p>
Provide intstructions to the site admin on how to use this plugin
</p>
</div>
<?php include_once(ISVIPI_ADMIN_BASE.'footer.php');?>
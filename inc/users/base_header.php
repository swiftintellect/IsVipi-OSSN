<?php 
getSEO();
global $meta_tags;
global $meta_description;
global $site_url;
global $site_status;
siteGenSett();
if ($site_status=="3"){
siteMaintanance();	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="<?php echo $meta_tags ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<title><?php echo "".$site_title.": ".$ACTION.""?></title>
<link rel="alternate" href="<?php echo "".$site_url."/feed"?>" title="RSS Feeds" type="application/rss+xml" />

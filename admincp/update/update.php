<?php
	//we create a new table mods
	$stmt = $db->prepare(
	'CREATE TABLE IF NOT EXISTS `mods` (
		  `id` int(5) NOT NULL AUTO_INCREMENT,
		  `mod_name` varchar(85) COLLATE utf8_unicode_ci NOT NULL,
		  `mod_url` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
		  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
		  `author` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
		  `author_url` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
		  `active` int(1) COLLATE utf8_unicode_ci NOT NULL,
		  PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1'
	);
	$stmt->execute();
	$stmt->close();
	
	//we create a new table blocked_users
	$stmt = $db->prepare(
	'CREATE TABLE IF NOT EXISTS `blocked_users` (
		`id` int(50) NOT NULL AUTO_INCREMENT,
		`user1` int(100) NOT NULL,
		`user2` int(100) NOT NULL,
		`timestamp` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  	PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1'
	);
	$stmt->execute();
	$stmt->close();
	
	//we add a new column addons_enabled to general_settings
	$stmt = $db->prepare(
	'ALTER TABLE general_settings ADD addons_enabled INT(1)'
	);
	$stmt->execute();
	$stmt->close();
	
	//we add a new column err_disabled to general_settings
	$stmt = $db->prepare(
	'ALTER TABLE general_settings ADD err_disabled INT(1)'
	);
	$stmt->execute();
	$stmt->close();
	
	//we add a new column newuser_notice to general_settings
	$stmt = $db->prepare(
	'ALTER TABLE general_settings ADD newuser_notice INT(1)'
	);
	$stmt->execute();
	$stmt->close();
	
	//we add a new column pm_deleted to pm
	$stmt = $db->prepare(
	"ALTER TABLE  pm ADD  pm_deleted VARCHAR(10) NOT NULL DEFAULT  '0'"
	);
	$stmt->execute();
	$stmt->close();
	
	
?>

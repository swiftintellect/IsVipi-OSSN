CREATE TABLE IF NOT EXISTS `isv_plugins` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `pluginname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `displayname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `developer` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `adminmenu` int(1) NOT NULL DEFAULT 0, 
  `usermenu` int(1) NOT NULL DEFAULT 0,
  `version` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `styles` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `js` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT INTO `isv_plugins` (`id`, `pluginname`, `displayname`, `description`, `developer`, `adminmenu`, `usermenu`, `version`, `styles`, `js`, `status`) 
VALUES (NULL, 'pages', 'Pages', 'This plugin will let your users create pages in your community.', 'IsVipi OSSN', '0', '0', '1.0.0', 'pages,page', 'pages,page', '0');

INSERT INTO `isv_plugins` (`id`, `pluginname`, `displayname`, `description`, `developer`, `adminmenu`, `usermenu`, `version`, `styles`, `js`, `status`) 
VALUES (NULL, 'groups', 'Groups', 'This plugin will let your users create groups in your community.', 'IsVipi OSSN', '0', '0', '1.0.0', 'groups,group', 'groups,group', '0');

CREATE TABLE IF NOT EXISTS `isv_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner` bigint(20) NOT NULL,
  `groupname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `grouptype` int(1) NOT NULL DEFAULT 1,
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cover` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rules` longtext COLLATE utf8_unicode_ci NOT NULL,
  `fave` int(2) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_group_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `joindate` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_group_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` bigint(20) NOT NULL,
  `request_join` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_group_discussions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `discussion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `images` int(1) NOT NULL DEFAULT 0,
  `att_link` varchar(255) COLLATE utf8_unicode_ci NULL,
  `att_title` varchar(255) COLLATE utf8_unicode_ci NULL,
  `att_description` varchar(255) COLLATE utf8_unicode_ci NULL,
  `att_video` varchar(255) COLLATE utf8_unicode_ci NULL,
  `att_image` varchar(255) COLLATE utf8_unicode_ci NULL,
  `timeposted` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_grouppost_likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `postid` bigint(20) NOT NULL,
  `timeliked` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_group_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `postid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `gcomment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timeposted` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_groupcomment_likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `commentid` bigint(20) NOT NULL,
  `timeliked` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner` bigint(20) NOT NULL,
  `pagename` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `industry` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Academic',
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cover` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fave` int(2) NOT NULL DEFAULT 0,
  `status` int(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_page_likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `likedate` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_page_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL,
  `adminid` bigint(20) NOT NULL,
  `post` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timeposted` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_pagepost_likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `postid` bigint(20) NOT NULL,
  `timeliked` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_post_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `postid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `gcomment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timeposted` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_pagecomment_likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `commentid` bigint(20) NOT NULL,
  `timeliked` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `banner` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NULL,
  `ntab` int(1) NOT NULL DEFAULT 1,
  `uploadtime` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_group_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` bigint(20) NOT NULL,
  `postid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `image` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_globalnotices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `notice` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `noticetime` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

ALTER TABLE `feeds` ADD `groupshare` BIGINT(20) NULL AFTER `att_image`, ADD `pageshare` BIGINT(20) NULL AFTER `groupshare`;

ALTER TABLE `isv_page_posts` ADD `images` INT(1) NOT NULL DEFAULT '0' AFTER `post`;
ALTER TABLE `isv_page_posts` ADD `att_link` VARCHAR(255) NULL AFTER `images`, ADD `att_title` VARCHAR(255) NULL AFTER `att_link`, ADD `att_description` VARCHAR(255) NULL AFTER `att_title`, ADD `att_video` VARCHAR(255) NULL AFTER `att_description`, ADD `att_image` VARCHAR(255) NULL AFTER `att_video`;
CREATE TABLE IF NOT EXISTS `isv_page_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL,
  `postid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `image` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

ALTER TABLE `feeds` ADD `sharedgroup` BIGINT(20) NULL AFTER `pageshare`, ADD `sharedpage` BIGINT(20) NULL AFTER `sharedgroup`;

CREATE TABLE IF NOT EXISTS `isv_page_button` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL UNIQUE,
  `button` int(2) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_page_phones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL UNIQUE,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `isv_page_contact` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL UNIQUE,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_page_signup` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL UNIQUE,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_page_emails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pageid` bigint(20) NOT NULL UNIQUE,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `isv_static_pages` (
  `id` tinyint unsigned NOT NULL DEFAULT 1,
  `aboutus` longtext COLLATE utf8_unicode_ci NULL,
  `privacy` longtext COLLATE utf8_unicode_ci NULL,
  `terms` longtext COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `isv_static_pages` (`id`) VALUES ('1');
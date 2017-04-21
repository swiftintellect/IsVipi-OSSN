--
-- SQL to create new fields in feeds table (att_link, att_title, att_description, att_video, att_image)
--

ALTER TABLE `feeds` ADD `att_link` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `old_feed_id`, ADD `att_title` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `att_link`, ADD `att_description` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `att_title`, ADD `att_video` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `att_description`, ADD `att_image` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `att_video`;

--
-- add encryption key column to table s_settings
--

ALTER TABLE `s_settings` ADD `encry_key` VARCHAR(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `admin_end`;

--
-- Update table `s_settings`
--

UPDATE `s_settings` SET encry_key = 'grQw57V4iJ3PgnBX' WHERE id = 1;

--
-- drop column newuser_notice from table s_settings
--

ALTER TABLE `s_settings` DROP `newuser_notice`;

--
-- drop column user_validate from table s_settings
--

ALTER TABLE `s_settings` DROP `user_validate`;

--
-- created a new table m_settings
--

CREATE TABLE IF NOT EXISTS `m_settings` (
  `id` int(1) NOT NULL,
  `allow_registration` tinyint(1) NOT NULL DEFAULT 1,
  `must_validate` tinyint(1) NOT NULL DEFAULT 1,
  `notify_acc_deletion` tinyint(1) NOT NULL DEFAULT 1,
  `notify_acc_undeletion` tinyint(1) NOT NULL DEFAULT 1,
  `notify_acc_suspension` tinyint(1) NOT NULL DEFAULT 1,
  `notify_acc_unsuspension` tinyint(1) NOT NULL DEFAULT 1,
  `notify_acc_activation` tinyint(1) NOT NULL DEFAULT 1,
  `notify_admin_newuser` tinyint(1) NOT NULL DEFAULT 1,
  `max_albums` int(2) NOT NULL DEFAULT 5,
  `max_photos_in_album` int(2) NOT NULL DEFAULT 10,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `m_settings`
--

INSERT INTO `m_settings` (`id`) VALUES
(1);

--
-- created a new table f_settings
--

CREATE TABLE IF NOT EXISTS `f_settings` (
  `id` int(1) NOT NULL,
  `number_feeds` int(3) NOT NULL DEFAULT 20,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `f_settings`
--

INSERT INTO `f_settings` (`id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `photo_albums`
--

CREATE TABLE IF NOT EXISTS `photo_albums` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL,
  `album` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `album_id` bigint(20) NOT NULL,
  `photo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL,
  `upload_date` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
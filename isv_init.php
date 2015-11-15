<?php
	/*******************************************************
	 *   Copyright (C) 2014  http://isvipi.org
	
		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation; either version 2 of the License, or
		(at your option) any later version.
	
		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.
	
		You should have received a copy of the GNU General Public License along
		with this program; if not, write to the Free Software Foundation, Inc.,
		51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
	 ******************************************************/ 
	 
//Base paths
$chop = -strlen(basename($_SERVER['SCRIPT_NAME']));
define('DOC_ROOT',substr($_SERVER['SCRIPT_FILENAME'],0,$chop));
define('URL_ROOT',substr($_SERVER['SCRIPT_NAME'],0,$chop));

// directory paths
define('ISVIPI_ROOT', DOC_ROOT);
define('ISVIPI_INC_BASE', ISVIPI_ROOT . 'isv_inc' . DIRECTORY_SEPARATOR);
define('ISVIPI_DB_BASE', ISVIPI_INC_BASE . 'isv_db' . DIRECTORY_SEPARATOR);
define('ISVIPI_UPLOADS_BASE', ISVIPI_INC_BASE . 'isv_uploads' . DIRECTORY_SEPARATOR);
define('ISVIPI_STYLE_BASE', ISVIPI_INC_BASE . 'isv_style.lib' . DIRECTORY_SEPARATOR);
define('ISVIPI_CLASSES_BASE', ISVIPI_INC_BASE . 'isv_classes' . DIRECTORY_SEPARATOR);
define('ISVIPI_FUNCTIONS_BASE', ISVIPI_INC_BASE . 'isv_functions' . DIRECTORY_SEPARATOR);
define('ISVIPI_PROCESS_BASE', ISVIPI_INC_BASE . 'isv_processes' . DIRECTORY_SEPARATOR);
define('ISVIPI_PAGES_BASE', ISVIPI_INC_BASE . 'isv_pages' . DIRECTORY_SEPARATOR);
define('ISVIPI_THEMES', ISVIPI_ROOT . 'isv_themes' . DIRECTORY_SEPARATOR);
define('ISVIPI_MOBILE_THEME_BASE', ISVIPI_THEMES . 'mobile' . DIRECTORY_SEPARATOR);
define('ISVIPI_PLUGINS_BASE', ISVIPI_ROOT . 'isv_plugins' . DIRECTORY_SEPARATOR);
define('ISVIPI_LANG_BASE', ISVIPI_ROOT . 'isv_lang' . DIRECTORY_SEPARATOR);

//admin base
define('ISVIPI_ADMIN_BASE', ISVIPI_ROOT . 'isv_admin' . DIRECTORY_SEPARATOR);
define('ISVIPI_ADMIN_INC_BASE', ISVIPI_ROOT . 'isv_inc/isv_admin' . DIRECTORY_SEPARATOR);
define('ISVIPI_ADMIN_PROC_BASE', ISVIPI_ADMIN_INC_BASE . 'processes' . DIRECTORY_SEPARATOR);
define('ISVIPI_ADMIN_CLS_BASE', ISVIPI_ADMIN_INC_BASE . 'classes' . DIRECTORY_SEPARATOR);

//cron base
define('ISVIPI_CRON_BASE', ISVIPI_INC_BASE . 'isv_cron' . DIRECTORY_SEPARATOR);

// url paths
define ('ISVIPI_URL', URL_ROOT);
define ('ISVIPI_FULL_HTTP_URL', $_SERVER['HTTP_HOST']);
define ('ISVIPI_STYLE_URL', ISVIPI_URL . 'isv_inc/isv_style.lib' .DIRECTORY_SEPARATOR);
define ('ISVIPI_UPLOADS_URL', ISVIPI_URL . 'isv_inc/isv_uploads' .DIRECTORY_SEPARATOR);

//local admin url
define ('ISVIPI_ADMIN_URL', ISVIPI_URL.'isv_admin'. DIRECTORY_SEPARATOR);

//cron job url
define ('ISVIPI_CRON_URL', ISVIPI_URL . 'cron' .DIRECTORY_SEPARATOR);

//Image thumbnail sizes
define('ISVIPI_THUMBS', '150x150_');
define('ISVIPI_600', '600x600_');

?>
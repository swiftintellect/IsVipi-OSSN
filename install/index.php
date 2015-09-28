<?php
ob_start();
session_set_cookie_params(0);
session_start();
/*******************************************************
 *   Copyright (C) 2014  http://isvipi.org

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 ******************************************************/ 
		require_once '../init.php';
		require_once '../inc/users.inc/users.func.php';

		$URL = str_replace(
			array( '\\', '../' ),
			array( '/',  '' ),
			$_SERVER['REQUEST_URI']
		);
		if ($offset = strpos($URL,'?')) {
			// strip getData
			$URL = substr($URL,0,$offset);
		} else if ($offset = strpos($URL,'#')) {
			$URL = substr($URL,0,$offset);
		}
		if (URL_ROOT != '/') $URL=substr($URL,strlen(URL_ROOT));
			$URL = trim($URL,'/');
		// 404 if trying to call a real file
		if (
			file_exists(DOC_ROOT.'/'.$URL) &&
			($_SERVER['SCRIPT_FILENAME'] != DOC_ROOT.$URL) &&
			($URL != '') &&
			($URL != 'index.php')
		) die404();
		$ACTION = (
			($URL == '') ||
			($URL == 'index.php') ||
			($URL == 'index.html')
		) ? array('index') : explode('/',html_entity_decode($URL));
		$includeFile = 'install'.preg_replace('/[^\w]/','','').'.php';
			//We set our site url parameters
			if ($ACTION[0] == 'installdb'){
				include_once DOC_ROOT.preg_replace('/[^\w]/','',$ACTION[0]).'.php';
			}
			else if (is_file($includeFile)) {
					include($includeFile);
			} 
			else die404();
	ob_end_flush();
?>
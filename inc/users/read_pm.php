<?php
/*******************************************************
 *   Copyright (C) 2014  http://isvipi.com

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
 if (isset($_SERVER['HTTP_REFERER'])){
 	$from_url = $_SERVER['HTTP_REFERER'];
 } else {
	$from_url = ISVIPI_URL.'messages';
 }
 isLoggedIn();
 $user = $_SESSION['user_id'];
 getUserDetails($user);
 pollUser($_SESSION['user_id']);
	if (isset($ACTION[1])){
		$convUser = $ACTION[1];
		if (!preg_match('/^[a-zA-Z0-9_]{1,60}$/', $convUser)){
		$_SESSION['err'] =NO_SUCH_CONV;
		header ('location:'.$from_url.'');
		exit();
		}
		xtractUID($convUser);
		$GLOBALS['uid'] = $uid;
		
 base_header($site_title,$ACTION[0]);
 include_once ISVIPI_THEMES_BASE.'read_pm.php';
 globalAlerts();
}
 ?>
</body>
</html>
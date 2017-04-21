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

	require_once ISVIPI_CLASSES_BASE.'global/cron.cls.php';
	$cron = new front_cron();
	
	//delete inactive sessions
	$cron->del_inactive_sessions();
	
	//delete unvalidated entries
	$cron->del_unvalidated_entries();
	
	//delete friend requests that have been ignored
	$cron->del_ignored_frnd_reqs();
	

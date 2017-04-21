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
	require_once(ISVIPI_PAGES_BASE .'m_base.php'); 
	require_once(ISVIPI_CLASSES_BASE .'global/search_cls.php');
	
	// capture our term
	if (!isset($PAGE[1]) ||  empty($PAGE[1])){
		$error = true;
	}
	
	$term = cleanGET($PAGE[1]);
	
	//initialize our search class
	$search = new search();
	$results = array_filter($search->find($term));
	
	
 	include_once ISVIPI_ACT_THEME.'search.php'; 

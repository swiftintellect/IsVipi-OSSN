<?php
	/*If you need any database table created, please include the necessary code here.
		This is the file that the system will look for during the installation of the addon
		
		In our example below, we will create a table named "test" with three columns (tf1, tf2 and tf3)
		
		Then we will insert some data into the table. We will later use this data in our front-end
		
	*/
//////////////////////////////////////////////////////////////
//////// Installing the addon ///////////////////////////////
////////////////////////////////////////////////////////////

//We have to check if the action we want is to install or uninstall. This is achieved using a session variable below.
//THIS IS A MUST!!!
if (isset($_SESSION['addon_action']) && ($_SESSION['addon_action'] == "install")){
	//Make sure that you include global $db (which is our database connector) before going ahead to create the table(s)
	global $db;
	
	// We first create the database table
	$sql="CREATE TABLE test_isv_test(id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(id), tf1 VARCHAR(30),tf2 VARCHAR(30),tf3 INT)ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";

	// Execute query
	if (!mysqli_query($db,$sql)) {
	  echo "Error creating table: " . mysqli_error($con);
	} 
	
	//We prepare variables to be inserted into the database
		$fld1 = strip_tags('fieldOne');
		$fld2 = strip_tags('fieldTwo');
		$fld3 = strip_tags('1');
	//Let us now dump some data into our table
	$stmt = $db->prepare('insert into test (tf1, tf2, tf3) values (?, ?, ?)');
	$stmt->bind_param('ssi', $fld1,$fld2,$fld3);
	$stmt->execute();
	$stmt->close();

//Since our install process is complete, we can unset our session variable
unset ($_SESSION['addon_action']);
}

//////////////////////////////////////////////////////////////
//////// Uninstalling the addon ////////////////////////////
////////////////////////////////////////////////////////////

//We have to check if the action we want is to install or uninstall. This is achieved using a session variable below.
//THIS IS A MUST!!!
if (isset($_SESSION['addon_action']) && ($_SESSION['addon_action'] == "uninstall")){
	//Since we are uninstalling the addon, we need all its data deleted from the database
	global $db;
	$stmt = $db->prepare('DROP TABLE test_isv_test');
	$stmt->execute();
	$stmt->close();
//Since our uninstall process is complete, we can unset our session variable
unset ($_SESSION['addon_action']);	
}
?>
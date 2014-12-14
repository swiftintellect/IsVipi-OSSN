<?php
//This is just a function to echo some text
function my_test_function(){
echo "This is my working mod";	
}

//This is a function to retrieve the data we saved into our database table when installing
function get_test_DbData(){
	global $db;
	global $Testid,$Testtf1,$Testtf2,$Testtf3;
	$stmt = $db->prepare("SELECT id,tf1,tf2,tf3 FROM test");
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Testid,$Testtf1,$Testtf2,$Testtf3);
	$stmt->fetch();
	$stmt->close();
}
?>
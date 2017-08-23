<?php
$query = $_REQUEST['query'];
$promenneFile = "../../../promenne.php";

if ( file_exists( $promenneFile ) && require $promenneFile ) { 
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query("SET CHARACTER SET UTF8") ) {
		echo $spojeni->query( $query ) ? "success" : "fail";
	} else echo "<h2>Connection with database had failed.</h2>";
} else echo "<h2>File $promenneFile doesn't found.</h2>";
?>
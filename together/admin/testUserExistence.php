<?php
$name = $_REQUEST['name'];
$promenneFile = "../../../promenne.php";

if ( file_exists( $promenneFile ) && require $promenneFile ) { 
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query("SET CHARACTER SET UTF8") ) {

		$cnt = 0;
		$sql = $spojeni->query( 'SELECT * FROM utrata_members WHERE name = "'.$name.'"' );
		
		while ( $row = mysqli_fetch_array( $sql ) ) {
			$cnt++;
		}
		if ( $cnt != 0 ) echo 'true';
		else echo 'false';
		
	} else echo "<h2>Connection with database had failed.</h2>";
} else echo "<h2>File $promenneFile doesn't found.</h2>";
?>
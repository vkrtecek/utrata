<?php
$id = $_REQUEST['id'];
$promenneFile = "../../../promenne.php";

if ( file_exists( $promenneFile ) && require $promenneFile ) { 
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query("SET CHARACTER SET UTF8") ) {

		$statement = "DELETE FROM utrata_members WHERE name = '".$id."'";
		$spojeni->query( $statement );
		$statement = "DROP TABLE IF EXISTS utrata_".$id;
		$spojeni->query( $statement );
		$statement = "DROP TABLE IF EXISTS utrata_check_state_".$id;
		$spojeni->query( $statement );
		$statement = "DROP TABLE IF EXISTS utrata_akt_hodnota_".$id;
		$spojeni->query( $statement );
		
	} else echo "<h2>Connection with database had failed.</h2>";
} else echo "<h2>File $promenneFile doesn't found.</h2>";
?>
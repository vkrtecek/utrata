<?php
$id = $_REQUEST['id'];
$promenneFile = "../../../promenne.php";

if ( file_exists( $promenneFile ) && require $promenneFile ) { 
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query("SET CHARACTER SET UTF8") ) {

		$statement = "DELETE FROM utrata_items WHERE UserID='".$id."'";
		$spojeni->query( $statement );
		$statement = "DELETE FROM utrata_check_state WHERE UserID='".$id."'";
		$spojeni->query( $statement );
		$statement = "DELETE FROM utrata_akt_hodnota WHERE UserID='".$id.'"';
		$spojeni->query( $statement );

		$statement = "DELETE FROM utrata_members WHERE name = '".$id."'";
		$spojeni->query( $statement );
				
	} else echo "<h2>Connection with database had failed.</h2>";
} else echo "<h2>File $promenneFile doesn't found.</h2>";
?>
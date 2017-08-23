<?php
$id = $_REQUEST['id'];
$table = $_REQUEST['table'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$spojeni->query( "UPDATE ".$table." SET platnost = 0 WHERE id = ".$id );
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>"
?>
<?php
$id = $_REQUEST['id'];
$user = $_REQUEST['user'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$spojeni->query( "DELETE FROM utrata_items WHERE UserID='".$user."' AND id = ".$id );
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>"
?>
<?php
$prikaz = $_REQUEST['prikaz'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$spojeni->query( $prikaz );
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>"
?>

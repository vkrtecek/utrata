<?php
$query = $_POST['query'];

if ( file_exists( "../promenne.php" ) && require( "../promenne.php" ) )
{
	if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
	{
		$conn->query( $query );
	}
}
?>
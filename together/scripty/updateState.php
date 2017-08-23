<?php
$table = $_REQUEST['table'];
$typ = $_REQUEST['typ'];
$value = $_REQUEST['value'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( file_exists( "../getMyTime().php" ) && require( "../getMyTime().php" ) )
	{
		if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
		{
			$statement = "INSERT INTO ".$table." ( typ, checked, value ) VALUES ( '".$typ."', '".getMyTime()."', '".$value."' )";
			$spojeni->query( $statement );
			echo $statement;
		}
		else echo '<p>Connection failed.</p>';
	}
	else echo "<p>File ../getMyTime().php doesn't exists.</p>";
}
else echo "<p>File ../../../promenne.php doesn't exists.</p>";

?>
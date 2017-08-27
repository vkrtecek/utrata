<?php
$col = $_REQUEST['col'];
$value = $_REQUEST['value'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$sql = $spojeni->query( "SELECT count(*) CNT FROM utrata_members WHERE ".$col."='".$value."'" );
		$res = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		echo $res['CNT'] > 0 ? 'duplicity' : 'success';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exists.</p>";

?>
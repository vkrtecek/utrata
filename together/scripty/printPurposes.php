<?php
$name = $_REQUEST['name'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$st = "SELECT * FROM utrata_Purposes WHERE PurposeID IN (SELECT PurposeID FROM utrata_UserPurposes WHERE UserID=(SELECT name FROM utrata_members WHERE login='".$name."'))";
		$sql = $spojeni->query( $st );
		echo '<p>Poznámka: <select name="nahr_pozn" id="nahr_pozn" size="1">';
		while ( $opt = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
			echo '<option value="'.$opt['PurposeID'].'">'.$opt['value'].'</option>';
		}
		echo '</select></p><br />';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>"
?>
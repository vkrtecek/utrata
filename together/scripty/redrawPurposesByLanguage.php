<?php
$language = $_REQUEST['language'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$st = "SELECT * FROM utrata_Purposes WHERE LanguageCode = '".$language."'";
		$sql = $spojeni->query( $st );
		while ($option = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
			echo '<option value="'.$option['code'].'">'.$option['value'].'</option>';
		}
	}
	else echo '<option>Connection failed.</option>';
}
else echo "<option>File ../../../promenne.php doesn't exist.</option>";
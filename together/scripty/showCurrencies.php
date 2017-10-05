<?php
$currency = $_REQUEST['currency'];
$login = $_REQUEST['login'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( file_exists( "../getMyTime().php" ) && require( "../getMyTime().php" ) )
	{
		if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
		{
			$statement = "SELECT * FROM utr_currencies";
			$sql = $spojeni->query( $statement );
			while ( $res = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
				if ( $res['value'] == $currency ) {
					$myCurrencyCode = $res['code'];
					break;
				}
			}
			
			$statement = "SELECT * FROM utr_currencies";
			$sql = $spojeni->query( $statement );
			echo '<select onChange="getCourseValue( \''.$myCurrencyCode.'\', \'courseHere\', this )">';
			while ( $curr = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
				echo '<option value="'.$curr['code'].'"';
				if ( $curr['value'] == $currency) echo ' selected=""';
				echo '>'.$curr['value'].'</option>';
			}
			echo '</select>';
			echo '<label for="courseHere"> '.translateByCode($spojeni, 'login', $login, 'AddItem.Form.CurrencyCourse').': </label>';
			echo '<input type="number" step="0.001" id="courseHere" value="1" />';
		}
		else echo '<p>Connection failed.</p>';
	}
	else echo "<p>File ../getMyTime().php doesn't exists.</p>";
}
else echo "<p>File ../../../promenne.php doesn't exists.</p>";

?>
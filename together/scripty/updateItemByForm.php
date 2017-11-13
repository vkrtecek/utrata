<?php
$id = $_REQUEST['ID'];
$name = $_REQUEST["name"];
$desc = $_REQUEST["desc"];
$purpose = $_REQUEST["purpose"];
$type = $_REQUEST["type"];
$price = $_REQUEST["price"];
$currencyCode = $_REQUEST["currencyCode"];
$date = $_REQUEST["date"];
$course = $_REQUEST["course"];
$odepsat = $_REQUEST["odepsat"];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$st = "SELECT CurrencyID FROM utr_currencies WHERE code='".$currencyCode."'";
		$sql = $spojeni->query( $st );
		$currency = mysqli_fetch_array($sql, MYSQLI_ASSOC);
		$currencyId = $currency['CurrencyID'];
		
		$st = "UPDATE utrata_items SET nazev='".$name."', popis='".$desc."', cena='".$price."', kurz='".$course."', CurrencyID='".$currencyId."', datum='".$date."', pozn=".$purpose.", typ='".$type."', odepsat=".$odepsat." WHERE ID=".$id;
		$spojeni->query( $st );
		echo 'success';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>";
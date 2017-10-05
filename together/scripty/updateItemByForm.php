<?php
$id = $_REQUEST['ID'];
$name = $_REQUEST["name"];
$desc = $_REQUEST["desc"];
$purpose = $_REQUEST["purpose"];
$type = $_REQUEST["type"];
$price = $_REQUEST["price"];
	$currency = $_REQUEST["currency"];
$date = $_REQUEST["date"];
$course = $_REQUEST["course"];
$odepsat = $_REQUEST["odepsat"];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$st = "UPDATE utrata_items SET nazev='".$name."', popis='".$desc."', cena='".$price."', kurz='".$course."', datum='".$date."', pozn=".$purpose.", typ='".$type."', odepsat=".$odepsat." WHERE ID=".$id;
		$spojeni->query( $st );
		echo 'success';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>";
<?php
//$name = $_REQUEST['id'];
$name = $_REQUEST['name'];
$login = $_REQUEST['login'];
$passwd = $_REQUEST['passwd'];
$sendMonthly = $_REQUEST['sendMonthly'];
$sendByOne = $_REQUEST['sendByOne'];
$mother = $_REQUEST['mother'];
$me = $_REQUEST['me'];
$currency = $_REQUEST['currency'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$st = "UPDATE utrata_members SET login='".$login."', passwd='".$passwd."', sendMonthly=".$sendMonthly.", sendByOne=".$sendByOne.", mother='".$mother."', me='".$me."', currencyID=".$currency." WHERE name='".$name."'";
		$spojeni->query( $st );
		echo 'success';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exists.</p>";

?>
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
$purposes = explode( ',', $_REQUEST['purposes'] );

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$st = "UPDATE utrata_members SET login='".$login."', passwd='".$passwd."', sendMonthly=".$sendMonthly.", sendByOne=".$sendByOne.", mother='".$mother."', me='".$me."', currencyID=".$currency." WHERE name='".$name."'";
		$spojeni->query( $st );
		
		//convert purposes to string usable in SQL statement
		$arrayToSQL = '';
		for ( $i = 0; $i < count($purposes); $i++ ) {
			$arrayToSQL .= '"'.$purposes[$i].'"';
			if ( $i != count($purposes)-1 ) $arrayToSQL .= ', ';
		}
		
		$lessPurposes = "DELETE FROM utrata_UserPurposes WHERE UserID='".$name."' AND PurposeID NOT IN ( SELECT PurposeID FROM utrata_Purposes WHERE code IN (".$arrayToSQL.") )";
		$spojeni->query( $lessPurposes );
		
		$morePurposes = "INSERT INTO utrata_UserPurposes ( UserID, PurposeID ) SELECT name, PurposeID FROM utrata_members CROSS JOIN utrata_Purposes WHERE name='".$name."' AND PurposeID IN ( SELECT PurposeID FROM utrata_Purposes WHERE code IN (".$arrayToSQL.") AND PurposeID NOT IN (SELECT PurposeID FROM utrata_UserPurposes WHERE UserID='".$name."') )";
		$spojeni->query( $morePurposes );
		
		echo 'success';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exists.</p>";

?>
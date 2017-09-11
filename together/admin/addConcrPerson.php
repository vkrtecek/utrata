<?php
$name = $_REQUEST['name'];
$login = $_REQUEST['login'];
$passwd = $_REQUEST['passwd'];
$sendMonthly = $_REQUEST['sendMonthly'];
$sendByOne = $_REQUEST['sendByOne'];
$mother = $_REQUEST['mother'];
$me = $_REQUEST['me'];
$language = $_REQUEST['language'];
$currency = $_REQUEST['currency'];
$promenneFile = "../../../promenne.php";

if ( file_exists( $promenneFile ) && require $promenneFile ) { 
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query("SET CHARACTER SET UTF8") ) {

		$statement = "INSERT INTO utrata_members ( name, login, passwd, sendMonthly, sendByOne, mother, me, CurrencyID, LanguageCode ) VALUES ( '".$name."', '".$login."', '".$passwd."', ".$sendMonthly.", ".$sendByOne.", '".$mother."', '".$me."', '".$currency."', '".$language."' )";
		$spojeni->query( $statement );
		
		$insert = "INSERT INTO utrata_check_state ( UserID, typ, checked, value ) VALUES ( '".$name."', 'karta', '0000-00-00 00:00:00', 0.0 );";
		$spojeni->query( $insert );
		$insert = "INSERT INTO utrata_check_state ( UserID, typ, checked, value ) VALUES ( '".$name."', 'hotovost', '0000-00-00 00:00:00', 0.0 );";
		$spojeni->query( $insert );
		
		$insert = "INSERT INTO utrata_UserPurposes ( UserID, PurposeID ) SELECT A.name, B.PurposeID FROM utrata_members A CROSS JOIN utrata_Purposes B WHERE B.base=1 AND B.LanguageCode='".$language."'";
		$spojeni->query( $insert );
		
		echo "success";
		
	} else echo "<h2>Connection with database had failed.</h2>";
} else echo "<h2>File $promenneFile doesn't found.</h2>";
?>

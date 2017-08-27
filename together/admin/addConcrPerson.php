<?php
$name = $_REQUEST['name'];
$login = $_REQUEST['login'];
$passwd = $_REQUEST['passwd'];
$sendMonthly = $_REQUEST['sendMonthly'];
$sendByOne = $_REQUEST['sendByOne'];
$mother = $_REQUEST['mother'];
$me = $_REQUEST['me'];
$currency = $_REQUEST['currency'];
$promenneFile = "../../../promenne.php";

if ( file_exists( $promenneFile ) && require $promenneFile ) { 
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query("SET CHARACTER SET UTF8") ) {

		$statement = "INSERT INTO utrata_members ( name, login, passwd, sendMonthly, sendByOne, mother, me, CurrencyID ) VALUES ( '".$name."', '".$login."', '".$passwd."', ".$sendMonthly.", ".$sendByOne.", '".$mother."', '".$me."', '".$currency."' )";
		$spojeni->query( $statement );
		
		$createUtrata = "CREATE TABLE `utrata_".$name."` (
  `ID` bigint(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `popis` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `cena` double NOT NULL,
	`kurz` double default 1,
  `datum` datetime NOT NULL,
  `pozn` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `platnost` int(11) NOT NULL DEFAULT '1',
  `typ` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT 'karta',
	`vyber` INT(1) NOT NULL DEFAULT '0',
	`odepsat` INT(1) NOT NULL DEFAULT '0'
);";
		$createAktHodnota = "CREATE TABLE IF NOT EXISTS `utrata_akt_hodnota_".$name."` (
  `ID` int(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `datum` datetime NOT NULL,
  `hodnota` float NOT NULL,
  `duvod` varchar(61) COLLATE utf8_czech_ci DEFAULT NULL,
  `typ` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT 'karta',
  `idToDelete` bigint(18) NULL DEFAULT NULL
);";
		$createCheckState = "CREATE TABLE IF NOT EXISTS `utrata_check_state_".$name."` (
	`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`typ` varchar(50) COLLATE utf8_czech_ci NOT NULL,
	`checked` datetime NOT NULL,
	`value` double NOT NULL
);";
		
		
		$spojeni->query( $createUtrata );
		$spojeni->query( $createAktHodnota );
		$spojeni->query( $createCheckState );
		
		$insert = "INSERT INTO utrata_check_state_".$name." ( typ, checked, value ) VALUES ( 'karta', '0000-00-00 00:00:00', 0.0 );";
		$spojeni->query( $insert );
		$insert = "INSERT INTO utrata_check_state_".$name." ( typ, checked, value ) VALUES ( 'hotovost', '0000-00-00 00:00:00', 0.0 );";
		$spojeni->query( $insert );
		
		echo "success";
		
	} else echo "<h2>Connection with database had failed.</h2>";
} else echo "<h2>File $promenneFile doesn't found.</h2>";
?>
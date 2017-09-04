<?php
$suf = '_';
$name = $_REQUEST['name'];
$br = '

';
$insertInto1 = $insertInto2 = $insertInto3 = '';


$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$file = fopen( $name.'.txt', 'w' );
		
		
		
		
		$createTable1 = "CREATE TABLE utrata_items (
	ID bigint(4) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	UserID varchar(255) CHARACTER SET UTF8 COLLATE UTF8_CZECH_CI NOT NULL,
	nazev varchar(255) CHARACTER SET UTF8 COLLATE UTF8_CZECH_CI NOT NULL,
	popis varchar(255) CHARACTER SET UTF8 COLLATE UTF8_CZECH_CI,
	cena double NOT NULL,
	kurz double DEFAULT 1,
	datum datetime NOT NULL,
	pozn int(11) NOT NULL,
	platnost int(1) DEFAULT 1,
	typ varchar(255) CHARACTER SET UTF8 COLLATE UTF8_CZECH_CI NOT NULL DEFAULT 'karta',
	vyber int(1) DEFAULT 0,
	odepsat int(1) DEFAULT 0,
	FOREIGN KEY (UserID) REFERENCES utrata_members(name),
	FOREIGN KEY (pozn) REFERENCES utrata_Purposes(PurposeID)
);";
		$sql = $spojeni->query( "SELECT * FROM utrata_items WHERE UserID='".$name."'" );
		while ( $it = mysqli_fetch_array($sql) )
		{
			$insertInto1 .= "INSERT INTO `utrata_items` (`ID`, `UserID`, `nazev`, `popis`, `cena`, `kurz`, `datum`, `pozn`, `platnost`, `typ`, `vyber`, `odepsat`) VALUES ( '".$it['ID']."', '".$it['UserID']."', '".$it['nazev']."', '".$it['popis']."', '".$it['cena']."', '".$it['kurz']."', '".$it['datum']."', '".$it['pozn']."', '".$it['platnost']."', '".$it['typ']."', '".$it['vyber']."', '".$it['odepsat']."' );
";
		}
		
		
		
		
		
		$createTable2 = 'CREATE TABLE IF NOT EXISTS `utrata_akt_hodnota` (
  `ID` int(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`UserID` varchar(255) CHARSET SET UTF8 COLLATE UTF8_CZECH_CI NOT NULL,
  `datum` datetime NOT NULL,
  `hodnota` float NOT NULL,
  `duvod` varchar(61) CHARSET SET UTF8 COLLATE UTF8_CZECH_CI DEFAULT NULL,
  `typ` varchar(255) CHARSET SET UTF8 COLLATE UTF8_CZECH_CI NOT NULL DEFAULT \'karta\',
  `idToDelete` bigint(18) NULL DEFAULT NULL,
	FOREIGN KEY (UserID) REFERENCES utrata_members(name)
);';
		$sql = $spojeni->query( "SELECT * FROM utrata_akt_hodnota WHERE UserID='".$name."'" );
		while ( $it = mysqli_fetch_array($sql) )
		{
			$insertInto2 .= "INSERT INTO `utrata_akt_hodnota` (`ID`, `UserID`, `datum`, `hodnota`, `duvod`, `typ`, `idToDelete`) VALUES ( '".$it['ID']."', '".$it['UserID']."', '".$it['datum']."', '".$it['hodnota']."', '".$it['duvod']."', '".$it['typ']."', ".($it['idToDelete'] ? $it['idToDelete'] : "NULL")." );
";
		}
		
		
		
		
		
		
		$createTable3 = 'CREATE TABLE IF NOT EXISTS `utrata_check_state` (
	`ID` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	`UserID` varchar(255) CHARSET SET UTF8 COLLATE UTF8_CZECH_CI NOT NULL,
	`typ` varchar(50) CHARSET SET UTF8 COLLATE UTF8_CZECH_CI NOT NULL,
	`checked` datetime NOT NULL,
	`value` double NOT NULL,
	FOREIGN KEY (UserID) REFERENCES utrata_members(name)
);';
		$sql = $spojeni->query( "SELECT * FROM utrata_check_state WHERE UserID='".$name."'" );
		while ( $it = mysqli_fetch_array($sql) )
		{
			$insertInto3 .= "INSERT INTO `utrata_check_state` (`ID`, `UserID`, `typ`, `checked`, `value`) VALUES ( '".$it['ID']."', '".$it['UserID']."', '".$it['typ']."', '".$it['checked']."', '".$it['value']."' );
";
		}
		
		
		
		
		
		
		
		
		
		fwrite( $file, $createTable1 );
		fwrite( $file, $br );
		fwrite( $file, $insertInto1 );
		fwrite( $file, $br );
		fwrite( $file, $br );
		
		fwrite( $file, $createTable2 );
		fwrite( $file, $br );
		fwrite( $file, $insertInto2 );
		fwrite( $file, $br );
		fwrite( $file, $br );
		
		fwrite( $file, $createTable3 );
		fwrite( $file, $br );
		fwrite( $file, $insertInto3 );
		
		fclose( $file );
		
		echo 'true';
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";
?>
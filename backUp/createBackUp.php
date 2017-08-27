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
		
		
		
		
		$createTable1 = 'CREATE TABLE IF NOT EXISTS `utrata'.$suf.$name.'` (
	`ID` bigint(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`nazev` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
	`popis` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
	`cena` double NOT NULL,
	`kurz` double default 1,
	`datum` datetime NOT NULL,
	`pozn` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
	`platnost` int(11) NOT NULL DEFAULT \'1\',
	`typ` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT \'karta\',
	`vyber` int(1) default 0,
	`odepsat` int(1) default 0
);';
		$sql = $spojeni->query( "SELECT * FROM utrata".$suf.$name );
		while ( $it = mysqli_fetch_array($sql) )
		{
			$insertInto1 .= "INSERT INTO `utrata".$suf.$name."` (`ID`, `nazev`, `popis`, `cena`, `kurz`, `datum`, `pozn`, `platnost`, `typ`, `vyber`, `odepsat`) VALUES ( '".$it['ID']."', '".$it['nazev']."', '".$it['popis']."', '".$it['cena']."', '".$it['kurz']."', '".$it['datum']."', '".$it['pozn']."', '".$it['platnost']."', '".$it['typ']."', '".$it['vyber']."', '".$it['odepsat']."' );
";
		}
		
		
		
		
		
		/*carefully*///if ( $name == 'vojta' ) { $name = ''; $suf = ''; }
		$createTable2 = 'CREATE TABLE IF NOT EXISTS `utrata_akt_hodnota'.$suf.$name.'` (
  `ID` int(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `datum` datetime NOT NULL,
  `hodnota` float NOT NULL,
  `duvod` varchar(61) COLLATE utf8_czech_ci DEFAULT NULL,
  `typ` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT \'karta\',
  `idToDelete` bigint(18) NULL DEFAULT NULL
);';
		$sql = $spojeni->query( "SELECT * FROM utrata_akt_hodnota".$suf.$name );
		while ( $it = mysqli_fetch_array($sql) )
		{
			$insertInto2 .= "INSERT INTO `utrata_akt_hodnota".$suf.$name."` (`ID`, `datum`, `hodnota`, `duvod`, `typ`, `idToDelete`) VALUES ( '".$it['ID']."', '".$it['datum']."', '".$it['hodnota']."', '".$it['duvod']."', '".$it['typ']."', ".$it['idToDelete']." );
";
		}
		
		
		
		
		
		
		$createTable3 = 'CREATE TABLE IF NOT EXISTS `utrata_check_state'.$suf.$name.'` (
	`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`typ` varchar(50) COLLATE utf8_czech_ci NOT NULL,
	`checked` datetime NOT NULL,
	`value` double NOT NULL
)';
		$sql = $spojeni->query( "SELECT * FROM utrata_check_state".$suf.$name );
		while ( $it = mysqli_fetch_array($sql) )
		{
			$insertInto3 .= "INSERT INTO `utrata_check_state".$suf.$name."` (`id`, `typ`, `checked`, `value`) VALUES ( '".$it['id']."', '".$it['typ']."', '".$it['checked']."', '".$it['value']."' );
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
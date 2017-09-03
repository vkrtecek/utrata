<?php
/*
$checkTable = $_REQUEST['utrata_check_state_table'];
$countTable = $_REQUEST["utrata_table"];
$statTable = $_REQUEST["utrata_akt_hodnota_table"];
*/
$user = $_REQUEST['who'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$sql = $spojeni->query( 'SELECT value FROM utrata_members M LEFT JOIN utr_currencies C ON M.currencyID=C.CurrencyID WHERE M.name = "'.$user.'"' );
		$sql = mysqli_fetch_array( $sql );
		$currency = $sql['value'];
		
		
		$suma_celk_karta = 0;
		$suma_celk_hot = 0;
		$prikaz_karta = 'SELECT * FROM utrata_items WHERE UserID="'.$user.'" AND typ = "karta"';
		$prikaz_hot = 'SELECT * FROM utrata_items WHERE UserID="'.$user.'" AND typ = "hotovost"';
		$sql_karta = $spojeni->query($prikaz_karta);
		
		while ($cena = mysqli_fetch_array($sql_karta))
		{
			$suma_celk_karta += $cena['cena'];
		}
		
		$sql_hot = $spojeni->query($prikaz_hot);
		while ($cena = mysqli_fetch_array($sql_hot))
		{
			$suma_celk_hot += $cena['cena'];
		}
		$zustatek_karta = 0;
		$zustatek_hot = 0;
		$prikaz = 'SELECT * FROM utrata_akt_hodnota WHERE UserID="'.$user.'"';
		$sql = $spojeni->query($prikaz);
		while($ceny = mysqli_fetch_array($sql) )
		{
			if ( $ceny['typ'] == "karta" ) $zustatek_karta += $ceny['hodnota'];
			else if ( $ceny['typ'] == 'hotovost' ) $zustatek_hot += $ceny['hodnota'];
		}
		
		$zustatek_karta -= $suma_celk_karta;
		$zustatek_hot -= $suma_celk_hot;
		if ($zustatek_karta < 0) $redK = "red";
		else if ( $zustatek_karta == 0 ) $redK = "violet";
		else $redK = "";
		
		if ($zustatek_hot < 0) $redH = "red";
		else if ( $zustatek_hot == 0 ) $redH = "violet";
		else $redH = "";
		
		$sql = $spojeni->query("SELECT checked, value FROM utrata_check_state WHERE id = (SELECT max(id) FROM utrata_check_state WHERE UserID='".$user."' AND typ = 'karta')");
		$toto1 = mysqli_fetch_array( $sql );
		$sql = $spojeni->query("SELECT checked, value FROM utrata_check_state WHERE id = (SELECT max(id) FROM utrata_check_state WHERE UserID='".$user."' AND typ = 'hotovost')");
		$toto2 = mysqli_fetch_array( $sql );
		
		echo '<em>Zůstatek na kartě: 
					<button name="check_K" onclick="updateState( \'karta\', \'prostred\', \''.number_format((float)$zustatek_karta, 2, '.', '').'\', \''.$user.'\' )" class="'.$redK.'"><strong class="check_H">'.number_format((float)$zustatek_karta, 2, ',', ' ').' '.$currency.'</strong></button>
			  </em><span title="'.number_format((float)$toto1['value'], 2, ',', ' ').'">'.dateToReadableFormat($toto1['checked']).'</span><br />';
		echo '<em>Zůstatek hotovosti: 
					<button name="check_H" onclick="updateState( \'hotovost\', \'prostred\', \''.number_format((float)$zustatek_hot, 2, '.', '').'\', \''.$user.'\' )" class="'.$redH.'"><strong class="check_H">'.number_format((float)$zustatek_hot, 2, ',', ' ').' '.$currency.'</strong></button>
			  </em><span title="'.number_format((float)$toto2['value'], 2, ',', ' ').'">'.dateToReadableFormat($toto2['checked']).'</span>';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exists.</p>";

?>
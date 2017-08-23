<?php
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$table = $_REQUEST['table'];
$mother = $_REQUEST['mother'];
$where = $_REQUEST['where'];
$name = $_REQUEST['who'];

function ourMonth( $in )
{
	return $in == '01' ? 'leden' : ( $in == '02' ? 'únor' : ( $in == '03' ? 'březen' : ( $in == '04' ? 'duben' : ( $in == '05' ? 'květen' : ( $in == '06' ? 'červen' : ( $in == '07' ? 'červenec' : ( $in == '08' ? 'srpen' : ( $in == '09' ? 'září' : ( $in == '10' ? 'říjen' : ( $in == '11' ? 'listopad' : 'prosinec' ))))))))));
}

$promenne = '../../../promenne.php';
$myDate = "../getMyTime().php";
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( 'SELECT value FROM utrata_members M LEFT JOIN utr_currencies C ON M.currencyID=C.CurrencyID WHERE M.name = "'.$name.'"' );
		$sql = mysqli_fetch_array( $sql );
		$currency = $sql['value'];
		
		$all = $jidlo = $trans = $kosmet = $leky = $other = 0;
		$cnt = $cnt_J = $cnt_T = $cnt_K = $cnt_L = $cnt_O = 0;
		
		$sql = $spojeni->query("SELECT * FROM $table WHERE datum LIKE '%-".$month."-%' && datum LIKE '%".$year."-%' AND nazev NOT LIKE '%vyber%' AND popis NOT LIKE '%vyber%'");
		while ( $polozka = mysqli_fetch_array($sql) )
		{
			if ( $polozka['pozn'] == "jidlo" )
			{
				$jidlo += $polozka['cena'];
				$cnt_J++;
			}
			else if ( $polozka['pozn'] == "transport" )
			{
				$trans += $polozka['cena'];
				$cnt_T++;
			}
			else if ( $polozka['pozn'] == "kosmetika" )
			{
				$kosmet += $polozka['cena'];
				$cnt_K++;
			}
			else if ( $polozka['pozn'] == "leky" )
			{
				$leky += $polozka['cena'];
				$cnt_L++;
			}
			else if ( $polozka['pozn'] == "ostatni" )
			{
				$other += $polozka['cena'];
				$cnt_O++;
			}
			$cnt++;
		}
		$all = $jidlo + $trans + $kosmet + $leky + $other;
		echo '<p>Text zprávy:</p><br /><br />';
		echo '<p><strong>Vyúčtování za '.ourMonth($month).' roku '.$year.'.</strong></p>';
		echo '<p>Za jídlo: '.$jidlo.' '.$currency.' ('.$cnt_J.' položek)</p>';
		echo '<p>Za transport: '.$trans.' '.$currency.' ('.$cnt_T.' položek)</p>';
		echo '<p>Za kosmetiku: '.$kosmet.' '.$currency.' ('.$cnt_K.' položek)</p>';
		echo '<p>Za léky: '.$leky.' '.$currency.' ('.$cnt_L.' položek)</p>';
		echo '<p>Za ostatní: '.$other.' '.$currency.' ('.$cnt_O.' položek)</p>';
		echo '<br /><p>Počet položek: '.$cnt.' ('.$all.' '.$currency.')</p>';
		
		
		$subject = ucfirst( $name ).' - vyúčtování za '.ourMonth($month).' '.$year;
		$message = 'Za jídlo: '.$jidlo.' '.$currency.' ('.$cnt_J.' položek)<b>Za transport: '.$trans.' '.$currency.' ('.$cnt_T.' položek)<b>Za kosmetiku: '.$kosmet.' '.$currency.' ('.$cnt_K.' položek)<b>Za léky: '.$leky.' '.$currency.' ('.$cnt_L.' položek)<b>Za ostatní: '.$other.' '.$currency.' ('.$cnt_O.' položek)<b><b>Počet položek: '.$cnt.' ('.$all.' '.$currency.')';
		if ( file_exists($myDate) && require($myDate) ) $message .= '<b><b>'.dateToReadableFormat(getMyTime());
		$message .= '<b>http://vlcata.pohrebnisluzbazlin.cz/utrata/index.php';
		$headers = 'From: utrata <'.$spravce.'>';
		
		echo '<button onClick="reallySendToMother( \''.$month.'\', '.$year.', \''.$mother.'\', \''.$subject.'\', \''.$message.'\', \''.$headers.'\', \''.$where.'\' )">Opravdu poslat</button>';
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";
?>
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
		
		$totalPrice = $totalItems = 0;
		$purposes = array();
		
		$st = "SELECT * FROM utrata_UserPurposes UP LEFT JOIN utrata_Purposes P ON UP.PurposeID=P.PurposeID WHERE UserID='".$name."'";
		$sql = $spojeni->query( $st );
		while ( $purpose = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
			$st1 = "SELECT SUM(cena) SUM, COUNT(*) CNT FROM ".$table." WHERE datum LIKE '%-".$month."-%' && datum LIKE '%".$year."-%' AND vyber=0 AND pozn=".$purpose['PurposeID'];
			$sql1 = $spojeni->query( $st1 );
			$tmp = mysqli_fetch_array( $sql1, MYSQLI_ASSOC );
			
			$price[$purpose['value']] = $tmp['SUM'];
			$items[$purpose['value']] = $tmp['CNT'];
			$totalPrice += $tmp['SUM'];
			$totalItems += $tmp['CNT'];
			
			array_push( $purposes, $purpose['value'] );
		}
		

		echo '<p>Text zprávy:</p><br /><br />';
		echo '<p><strong>Vyúčtování za '.ourMonth($month).' roku '.$year.'.</strong></p>';
		foreach ( $price as $key => $val ) {
			echo '<p>Za '.$key.': '.$val.' '.$currency.' ('.number_format((float)$items[$key], 2, '.', ' ').' položek)<p>';
		}
		echo '<br /><p>Počet položek: '.$totalItems.' ('.number_format((float)$totalPrice, 2, '.', ' ').' '.$currency.')</p>';
		
		
		$subject = ucfirst( $name ).' - vyúčtování za '.ourMonth($month).' '.$year;
		$message = '';
		foreach ( $price as $key => $val ) {
			$message .= 'Za '.$key.': '.number_format((float)$val, 2, '.', ' ').' '.$currency.' ('.$items[$key].' položek)<b>';
		}
		$message .= '<b>Počet položek: '.$totalItems.' ('.number_format((float)$totalPrice, 2, '.', ' ').' '.$currency.')';
		if ( file_exists($myDate) && require($myDate) ) $message .= '<b><b>'.dateToReadableFormat(getMyTime());
		$message .= '<b>http://vlcata.pohrebnisluzbazlin.cz/utrata/index.php';
		$headers = 'From: utrata <'.$spravce.'>';
		
		echo '<button onClick="reallySendToMother( \''.$month.'\', '.$year.', \''.$mother.'\', \''.$subject.'\', \''.$message.'\', \''.$headers.'\', \''.$where.'\' )">Opravdu poslat</button>';
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";
?>
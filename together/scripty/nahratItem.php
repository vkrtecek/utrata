<?php
$user = $_REQUEST['user'];
$name =$_REQUEST['name'];
$desc = $_REQUEST['desc'];
$pozn = $_REQUEST['pozn'];
$type = $_REQUEST['type'];
$date = $_REQUEST['date'];
$price = $_REQUEST['price'];
$course = $_REQUEST['course'];
$vyber = $_REQUEST['vyber'];
$odepsat = $_REQUEST['odepsat'];
$poznForVyber = 5;

function toSQLTime( $in )
{
	$date = explode( 'T', $in );
	return $date[0].' '.$date[1].':00';
}

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( file_exists( "../getMyTime().php" ) && require( "../getMyTime().php" ) )
	{
		if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
		{			
			$totalPrice = number_format( $price * $course, 5, '.', '' );
			
			$sql = $spojeni->query( "SELECT * FROM utrata_items WHERE id = (SELECT max(id) FROM utrata_items WHERE UserID='".$user."')" );
			$last = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
			/*
			echo $last['nazev'].' == '.$name.'<br />';
			echo $last['popis'].' == '.$desc.'<br />';
			echo $last['cena'].' == '.$price.'<br />';
			echo $last['pozn'].' == '.$pozn.'<br />';
			echo $last['datum'].' == '.toSQLTime($date).'<br />';
			echo $last['typ'].' == '.$type.'<br />';
			*/
			if ( $last['nazev'] == $name && $last['popis'] == $desc && $last['cena'] == $price && $last['pozn'] == ($vyber ? $poznForVyber : $pozn) && $last['datum'] == toSQLTime($date) && $last['typ'] == $type ) echo 'duplicity';
			else {
				//setlocale(LC_ALL, 'czech');
				//$name = strtolower(preg_replace('/[^a-zA-Z0-9.]/','',iconv('UTF-8', 'ASCII//TRANSLIT', $name)));
				//$desc = strtolower(preg_replace('/[^a-zA-Z0-9.]/','',iconv('UTF-8', 'ASCII//TRANSLIT', $desc)));
			
				if ( $vyber ) { //výběr
					$spojeni->query("INSERT INTO utrata_items (UserID, nazev, popis, cena, kurz, pozn, datum, typ, vyber) VALUES ('".$user."', '".$name."', '".$desc."', ".$price.", '".$course."', ".$poznForVyber.", '".toSQLTime( $date )."', 'karta', 1)");
					$spojeni->query("INSERT INTO utrata_akt_hodnota (UserID, datum, hodnota, typ, duvod, idToDelete) VALUES ('".$user."', '".toSQLTime( $date )."', '".$totalPrice."', 'hotovost', 'Výběr', (SELECT MAX(id) FROM utrata_items WHERE UserID='".$user."'))");
				}	else { //ordinary item
					$spojeni->query("INSERT INTO utrata_items (UserID, nazev, popis, cena, kurz, pozn, datum, typ, odepsat) VALUES ('".$user."', '".$name."', '".$desc."', '".$price."', '".$course."', '".$pozn."', '".toSQLTime( $date )."', '".$type."', ".$odepsat.")");
					
					$sql = $spojeni->query( "SELECT M.*, C.value FROM utrata_members M LEFT JOIN utr_currencies C ON M.currencyID=C.CurrencyID WHERE M.name='".$user."'" );
					$usr = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
					
					if ( $usr['sendByOne'] == 1 ) {
						$mailphp = '../mail.php';
						if ( file_exists($mailphp) && require($mailphp) ) {
							$to = $usr['mother'];
							$subject = 'Další '.$user.'\'s útrata';
							$message = '
							Název: '.$name.'
							Poopis: '.$desc.'
							Typ: '.$pozn.'
							Cena: '.$totalPrice.' '.$usr['value'].'
							
							('.dateToReadableFormat( getMyTime() ).')
							http://vlcata.pohrebnisluzbazlin.cz/index.php';
							$headers = 'From: utrata <'.$spravce.'>\n';
							
							my_mail($to, $subject, $message, $headers);
						}
						else echo 'Soubor mail.php se nepodařilo najít.';
					}
				}
				echo 'success';
			}
		}
		else echo '<p>Connection failed.</p>';
	}
	else echo "<p>File ../getMyTime().php doesn't exists.</p>";
}
else echo "<p>File ../../../promenne.php doesn't exists.</p>";

?>
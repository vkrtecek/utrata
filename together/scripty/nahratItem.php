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

function toSQLTime( $in )
{
	$date = explode( 'T', $in );
	return $date[0].' '.$date[1];
}

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( file_exists( "../getMyTime().php" ) && require( "../getMyTime().php" ) )
	{
		if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
		{			
			$totalPrice = number_format( $price * $course, 5, '.', '' );
			
			$sql = $spojeni->query( "SELECT * FROM utrata_".$user." WHERE id = (SELECT max(id) FROM utrata_".$user.")" );
			$last = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
					
			if ( $last['nazev'] == $name && $last['popis'] == $desc && $last['cena'] == $price && $last['pozn'] == $pozn && $last['datum'] == toSQLTime($date) && $last['typ'] == $type ) echo 'duplicity';
			else {
				//setlocale(LC_ALL, 'czech');
				//$name = strtolower(preg_replace('/[^a-zA-Z0-9.]/','',iconv('UTF-8', 'ASCII//TRANSLIT', $name)));
				//$desc = strtolower(preg_replace('/[^a-zA-Z0-9.]/','',iconv('UTF-8', 'ASCII//TRANSLIT', $desc)));
			
				if ( $vyber ) { //výběr
					$spojeni->query("INSERT INTO utrata_".$user." (nazev, popis, cena, kurz, pozn, datum, typ, vyber) VALUES ('".$name."', '".$desc."', '".$price."', '".$course."', 'ostatni', '".toSQLTime( $date )."', 'karta', 1)");
				
					$sql = $spojeni->query( "SELECT max(id) MAX FROM utrata_".$user );
					$max = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
					$spojeni->query("INSERT INTO utrata_akt_hodnota_".$user." (datum, hodnota, typ, duvod, idToDelete) VALUES ('".toSQLTime( $date )."', '".$totalPrice."', 'hotovost', 'Výběr', ".$max['MAX'].")");
				}	else { //ordinary item
					$spojeni->query("INSERT INTO utrata_".$user." (nazev, popis, cena, kurz, pozn, datum, typ, odepsat) VALUES ('".$name."', '".$desc."', '".$price."', '".$course."', '".$pozn."', '".toSQLTime( $date )."', '".$type."', ".$odepsat.")");
					
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
			}
			echo 'success';
		}
		else echo '<p>Connection failed.</p>';
	}
	else echo "<p>File ../getMyTime().php doesn't exists.</p>";
}
else echo "<p>File ../../../promenne.php doesn't exists.</p>";

?>
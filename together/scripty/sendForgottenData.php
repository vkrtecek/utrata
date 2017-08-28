<?php
$mail = $_REQUEST['mail'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$st1 = 'SELECT count(*) CNT FROM utrata_members WHERE me="'.$mail.'"';
		$st2 = 'SELECT * FROM utrata_members WHERE me="'.$mail.'"';
		
		$sql = $spojeni->query( $st1 );
		$res = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		if ( $res['CNT'] > 1 ) { // more mails
			echo 'Více lidí má stejný mail. Kontaktujte správce webu ('.$spravce.')';
		} else if ( $res['CNT'] == 1 ) { //success
			$sql = $spojeni->query( $st2 );
			$person = mysqli_fetch_array($sql, MYSQLI_ASSOC);
			$subject = 'Útrata '.$person['name'].' - zapomenuté údaje';
			$message = 'Přihlašovací jméno: '.$person['login'].'
heslo: '.$person['passwd'];
			$header = 'From: Útrata<'.$spravce.'>\n';
			mail( $mail, $subject, $message, $header );
			echo 'success';
		} else if ( $res['CNT'] < 1 ) { //nobody
			echo 'Nikdo s takovým mailem není v databázi veden';
		} else { //some error
			echo 'some error in SQL statement';
		}
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>"
?>
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
			echo translateByCode( $spojeni, 'LanguageCode', 'CZK', 'Login.Forgotten.Modal.Status.MorePeopleWithSameMail').' ('.$spravce.')';
		} else if ( $res['CNT'] == 1 ) { //success
			$sql = $spojeni->query( $st2 );
			$person = mysqli_fetch_array($sql, MYSQLI_ASSOC);
			$to = $person['me'];
			$subject = translateByCode($spojeni, 'login', $person['login'], 'Login.Forgotten.Mail.Subject.AppName').' '.$person['name'].' - '.translateByCode($spojeni, 'login', $person['login'], 'Login.Forgotten.Mail.Subject.Specification');
			$message = translateByCode($spojeni, 'login', $person['login'], 'Login.Forgotten.Mail.Message.Login').': '.$person['login'].'
'.translateByCode($spojeni, 'login', $person['login'], 'Login.Forgotten.Mail.Message.Password').': '.$person['passwd'];
			$headers = 'From: Útrata<'.$spravce.'>';
			
			function autoUTF($s)
			{
				// detect UTF-8
				if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
					return $s;
				// detect WINDOWS-1250
				if (preg_match('#[\x7F-\x9F\xBC]#', $s))
					return iconv('WINDOWS-1250', 'UTF-8', $s);
				// assume ISO-8859-2
				return iconv('ISO-8859-2', 'UTF-8', $s);
			}
			 
			function cs_mail ($to, $subject, $message, $headers = "")
			{
				$subject = "=?utf-8?B?".base64_encode(autoUTF ($subject))."?=";
				//$headers .= "MIME-Version: 1.0\n";
				//$headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
				//$headers .= "Content-Transfer-Encoding: base64\n";
				//$message = base64_encode (autoUTF ($message));
				return mail($to, $subject, $message, $headers);
			}
			if (cs_mail($to, $subject, $message, $headers))
				echo 'success';
			else
				echo translateByCode($spojeni, 'LanguageCode', 'CZK', 'Login.Forgotten.Modal.Status.MailNotSent');
		} else if ( $res['CNT'] < 1 ) { //nobody
			echo translateByCode($spojeni, 'LanguageCode', 'CZK', 'Login.Forgotten.Modal.Status.Nobody');
		} else { //some error
			echo translateByCode($spojeni, 'LanguageCode', 'CZK', 'Login.Forgotten.Modal.Status.SQLStatementError');
		}
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>"
?>
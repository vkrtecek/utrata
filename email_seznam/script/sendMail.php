<?php
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
 
function cs_mail ($to, $subject, $message, $headers)
{
	$subject = "=?utf-8?B?".base64_encode(autoUTF ($subject))."?=";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/plain; charset=\"UTF-8\"\n";
	$headers .= "Content-Transfer-Encoding: base64\n";
	$message = base64_encode (autoUTF ($message));
	return mail($to, $subject, $message, $headers);
}



function my_mail($to, $subject, $message, $headers)
{
	if (!cs_mail($to, $subject, $message, $headers)) echo 'E-mail se nepodařilo odeslat.';
}


function isInDatabase( $mail, $conn, $table )
{
	$mail = explode( "@", $mail );
	$result = $conn->query( "SELECT count(*) CNT FROM ".$table." WHERE user = '".$mail[0]."' AND domain = '".$mail[1]."'" );
	$person = mysqli_fetch_array( $result );
	
	if ( $person['CNT'] == 1 ) return true;
	return false;
}
function getNick( $mail )
{
	if ( file_exists( "../promenne.php" ) && require( "../promenne.php" ) )
	{
		if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
		{
			$mail = explode( "@", $mail );
			$table = $conn->query( "SELECT nick NICK FROM ".$db_users." WHERE user = '".$mail[0]."' AND domain = '".$mail[1]."'" );//
			$person = mysqli_fetch_array( $table );
			return $person['NICK'];
		}
		else return '';
	}
	else return '';
}











$toMail = $_POST['mail'];
$subject = $_POST['subject'];
$text = $_POST['text'];
$from = $_POST['from'];
$headers = 'From: '.getNick( $from ).' <'.$from.'>\n';


if ( file_exists( "../promenne.php" ) && require( "../promenne.php" ) )
{
	if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
	{
		if ( !isInDatabase( $toMail, $conn, $db_users) )
		{
			my_mail( $toMail, $subject, $text, $headers );
		}
		$conn->query( "INSERT INTO ".$db_box." ( eFrom, eTo, eSubject, eText, eDate ) VALUES ( '".$from."', '".$toMail."', '".str_replace( "'", '\\\'', $subject )."', '".str_replace( "'", '\\\'', $text )."', now() );" );
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../promenne.php doesn't exists.</p>";
?>
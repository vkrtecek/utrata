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
	if (!cs_mail($to, $subject, $message, $headers)) echo 'Cannot send an e-mail.';
}
?>
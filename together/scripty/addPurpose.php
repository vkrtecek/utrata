<?php
$login = $_REQUEST['login'];
$purpose = $_REQUEST['purpose'];
$language = $_REQUEST['language'];

function toCode( $str ) {
	$unwanted_array = array(	'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
														'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
														'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
														'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
														'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ě'=>'e', 'Ě'=>'E', 'č'=>'c', 'Č'=>'C', 'ř'=>'r', 'Ř'=>'R',
														'ů'=>'u', 'Ů'=>'U', 'ď'=>'d', 'Ď'=>'D', 'ť'=>'t', 'Ť'=>'T', 'ň'=>'n', 'Ň'=>'N' );
	$str = strtr( $str, $unwanted_array );
	return strtolower( $str );
}

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$st = "SELECT count(*) CNT FROM utrata_Purposes WHERE code='".toCode( $purpose )."' AND LanguageCode='".$language."'";
		$sql = $spojeni->query( $st );
		$tmp = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		if ( $tmp['CNT'] > 0 ) {
			echo 'code "'.toCode($purpose).'" already exists';
		} else if ( $tmp['CNT'] == 0 ) {
			$spojeni->query( "INSERT INTO utrata_Purposes ( code, value, LanguageCode, CreatorID ) VALUES ( '".toCode( $purpose )."', '".$purpose."', '".$language."', '".$login."' );" );
			$spojeni->query( "INSERT INTO utrata_UserPurposes ( UserID, PurposeID ) VALUES ( (SELECT name FROM utrata_members WHERE login='".$login."'), (SELECT PurposeID FROM utrata_Purposes WHERE value='".$purpose."') )" );
			echo 'success';
		} else echo 'other error';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>"
?>
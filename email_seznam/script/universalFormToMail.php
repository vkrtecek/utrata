<?php
$id = isset($_POST['id']) ? $_POST['id'] : '';
$where = isset($_POST['where']) ? $_POST['where'] : '';
$query = isset($_POST['query']) ? $_POST['query'] : '';
$bolt = isset($_POST['bolt']) ? $_POST['bolt'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$typeOfPage = isset($_POST['typeOfPage']) ? $_POST['typeOfPage'] : '';
$info = "{ 'bolt' : '".$bolt."', 'type' : '".$type."' }";
$name = $_POST['name'];
$domain = $_POST['domain'];



function getEmailInfoById( $id = 0 )
{
	if ( $id && file_exists( "../promenne.php" ) && require( "../promenne.php" ) )
	{
		if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
		{
			$table = $conn->query( "SELECT * FROM ".$db_box." WHERE ID = ".$id );
			$row = mysqli_fetch_array( $table );
			return array(
				"ID" => $row['ID'],
				"To" => $row['eTo'],
				"From" => $row['eFrom'],
				"Subject" => $row['eSubject'],
				"Text" => $row['eText'],
				"Date" => $row['eDate'],
				"Reat" => $row['eReat'],
				"Trashed" => $row['eDel'],
				"SPAM" => $row['eSpam'],
				"DeletedR" => $row['eRecValid'],
				"DeletedS" => $row['eSendValid']
			);
		}
		else return false;
	}
	else return false;
}


function getNick( $address )
{
	if ( file_exists( "../promenne.php" ) && require( "../promenne.php" ) )
	{
		if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name ) ) && $conn->query( "SET CHARACTER SET UTF8" ) )
		{
			$table = $conn->query( "SELECT user, domain, nick FROM ".$db_users );
			while ( $row = mysqli_fetch_array( $table ) )
			{
				if ( $row['user'].'@'.$row['domain'] == $address ) return $row['nick'];
			}
			return $address;
		}
		else return $address;
	}
	else return $address;
}












/*echo 'Status:<br>';
if ( $id ) echo 'id: '.$id.'<br>';
echo 'where: '.$where.'<br>';
echo 'query: '.$query.'<br>'; //if ( $query ) is equat to if ( $query == '' ) 
echo 'bolt: '.$bolt.'<br>';
echo 'type: '.$type.'<br>';
echo 'typeOfPage: '.$typeOfPage.'<br>';
*/
if ( !($result = getEmailInfoById( $id )) )
{
	switch ( $type )
	{
		case 'newMail':
			$result = array(
				"To" => "",
				"From" => "",
				"Subject" => "",
				"Text" => ""
			);
			break;
		case 'settings':
			$result = true;
			break;
		default:
			echo "<p>Error no. 100 - Page doesn't exists yet.</p>";
			break;
	}
}


function testIfRE( $str )
{
	if ( $str[0] == 'R' && $str[1] == 'E' && $str[2] == ':' && $str[3] == ' ' ) return true;
	return false;
}



function printFormWithMail( $where, $name, $domain, $id, $result = false, $typeOfPage = "", $query = "", $info = "''" )
{
	if ( $typeOfPage )//button back
	{
		echo '<div id="navigationCurMail">';
		echo "<button onclick=\"showMails( '".$where."', '".$query."', ".$info.")\"><img src=\"img/back.png\" alt=\"Zpět\" title=\"Zpět\"/></button>";
		echo '</div>';
	}
	
	$tMail = getEmailInfoById( $id );
	$replyPreText = '

---------- Původní zpráva ----------
Od: '.getNick( $tMail['From'] ).' <'.$tMail['From'].'>
Komu: '.getNick( $tMail['To'] ).' <'.$tMail['To'].'>
Datum: '.$tMail['Date'].'
Předmět: '.$tMail['Subject'].'

';
	$reSendPreText = $replyPreText;
	
	
	
	
	echo '<form method="post" id="writeMailForm">';
	echo '<input type="hidden" name="sender" value="'.($name.'@'.$domain).'" id="input0Form" />';
	echo '<table rules="none">';
		echo '<tr>';
			echo '<td><p>Pro: </p></td>';
			echo '<td><input type="text" name="Reciever" id="input1Form" value="';
				echo isset($_POST['Reciever']) ? $_POST['Reciever'] : ($typeOfPage == 'reply' ? $result['From'] : '');
			echo '" /></td>';
		echo '</tr><tr>';
			echo '<td><p>Předmět:</p></td>';
			echo '<td><input type="text" name="Subject" id="input2Form" value="';
				echo (isset($_POST['Subject']) ? $_POST['Subject'] : ($result['Subject'] ? (testIfRE($result['Subject']) ? $result['Subject'] : 'RE: '.$result['Subject']) : ''));
			echo '" /></td>';
		echo '</tr><tr>';
			echo '<td colspan="2"><textarea name="Text" id="textareaForm" >';
			if ( $typeOfPage == 'reSend' ) echo $reSendPreText;
			else if ( $typeOfPage == 'reply' ) echo $replyPreText;
			echo (isset($_POST['Text']) ? $_POST['Text'] : ($result['Text'] ? $result['Text'] : '')).'</textarea></td>';
		echo '</tr><tr>';
			echo '<td colspan="2"><input type="button" name="submit" id="submit" value="Odeslat" onclick="checkValuesToSendMail( \'warningsWithSending\', \''.$where.'\', \''.$query.'\', '.$info.' )" /></td>';
		echo '</tr>';
		echo '</tr><tr>';
			echo '<td colspan="2" id="warningsWithSending"></td>';
		echo '</tr>';
	echo '</table>';
	echo '</form>';
}





if ( $result )
{
	if ( isset($result['To']) )//this will be form for e-mail
	{
		if ( $result['To'] ) //edit seted mail
		{
			printFormWithMail( $where, $name, $domain, $id, $result, $typeOfPage, str_replace( "'", '\\\'', $query ), $info );
        }
		else //new mail
		{	
			printFormWithMail( $where, $name, $domain, $id );
		}
	}
	/*else //settings
	{
		if ( file_exists( "settings.php" ) ) require( "settings.php" );
		else echo '<p>Nastavení se nepodařilo načíst</p>';
	}*/
} ?>
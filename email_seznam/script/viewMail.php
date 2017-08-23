<?php
$where = $_POST['where'];
$query = str_replace( "'", "\\'", $_POST['query'] );
$bolt = $_POST['bolt'];
$type = $_POST['type'];
$id = $_POST['id'];
$info = "{ 'bolt' : '".$bolt."', 'type' : '".$type."' }";

function toPerson( $address, $conn, $table )
{
	$table = $conn->query( "SELECT user, domain, nick FROM ".$table );
	while ( $row = mysqli_fetch_array( $table ) )
	{
		if ( $row['user'].'@'.$row['domain'] == $address ) return $row['nick'];
	}
	return false;
}

if ( file_exists( "../promenne.php" ) && require( "../promenne.php" ) )
{
	if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
	{
		if ( $type == 'inBox' || $type == 'nonReat' ) $conn->query( "UPDATE ".$db_box." SET eReat = 1 WHERE ID = ".$id );
		$table = $conn->query( "SELECT * FROM ".$db_box." WHERE ID = ".$id );
		$row = mysqli_fetch_array( $table );
		
		echo '<div id="navigationCurMail">';
		echo "<button onclick=\"showMails( '".$where."', '".$query."', ".$info.")\"><img src=\"img/back.png\" alt=\"Zpět\" title=\"Zpět\"/></button>";
		if ( $type == 'binBox' || $type == 'spamBox' )
			echo "<button onclick=\"backToInBox( ".$id.", '".$where."', '".$query."', ".$info.", '".$_POST['name']."', '".$_POST['domain']."' )\"><img src=\"img/inBox.png\" alt=\"Do doručených\" title=\"Do doručených\"/></button>";
		if ( $type == 'nonReat' || $type == 'inBox' || $type == 'spamBox' )
			echo "<button onclick=\"mailToBin( ".$id.", '".$where."', '".$query."', ".$info.", '".$_POST['name']."', '".$_POST['domain']."' )\"><img src=\"img/toBin.png\" alt=\"Do koše\" title=\"Do koše\"/></button>";
		if ( $type == 'outBox' || $type == 'binBox' || $type == 'spamBox' )
			echo "<button onclick=\"deleteMail( ".$id.", '".$where."', '".$query."', ".$info.", '".$type."', '".$_POST['name']."', '".$_POST['domain']."' )\"><img src=\"img/delete.png\" alt=\"Smazat\" title=\"Smazat\"/></button>";
		if ( $type == 'nonReat' || $type == 'inBox' || $type == 'binBox' )
			echo "<button onclick=\"mailToSpam( ".$id.", '".$where."', '".$query."', ".$info.", '".$_POST['name']."', '".$_POST['domain']."' )\"><img src=\"img/spam.png\" alt=\"SPAM\" title=\"Spam\"/></button>";
		if ( $type == 'nonReat' || $type == 'inBox' )
			echo "<button onclick=\"mailReply( ".$id.", '".$where."', '".$query."', ".$info.", '".$_POST['name']."', '".$_POST['domain']."' )\"><img src=\"img/reply.png\" alt=\"Odpovědět\" title=\"Odpovědět\"/></button>";
		if ( $type == 'nonReat' || $type == 'inBox' || $type == 'outBox' )
			echo "<button onclick=\"mailResend( ".$id.", '".$where."', '".$query."', ".$info.", '".$_POST['name']."', '".$_POST['domain']."' )\"><img src=\"img/reSend.png\" alt=\"Přeposlat\" title=\"Přeposlat\"/></button>";
		echo '</div>';
		
		echo '<div id="concMail">';
		echo ( $person = toPerson( $row['eFrom'], $conn, $db_users ) ) ? '<p><strong>Od:</strong> '.$person.' (<em>'.$row['eFrom'].'</em>)</p>' : '<p><strong>Od:</strong> '.$row['eFrom'].'</p>';
		echo ( $person = toPerson( $row['eTo'], $conn, $db_users ) ) ? '<p><strong>Pro:</strong> '.$person.' (<em>'.$row['eTo'].'</em>)</p>' : '<p><strong>Od:</strong> '.$row['eTo'].'</p>';
		echo '<p><strong>Datum:</strong> '.$row['eDate'].'</p>';
		echo '<br />';
		echo '<p><strong>Předmět:</strong> '.$row['eSubject'].'</p>';
		echo '<hr />';
		echo '<textarea id="viewMailTextArea" disabled>';
		echo $row['eText'];
		echo '</textarea>';
		echo '</div>';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../promenne.php doesn't exists.</p>";
?>
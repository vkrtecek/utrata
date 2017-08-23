<?php
$query = $_POST['query'];
$where = $_POST['where'];
$bolt = $_POST['bolt'];
$type = $_POST['type'];
$shift = $bolt == 'true' ? 1 : 0;
$maxMessLen = 40;
$info = "{ 'bolt' : '".$bolt."', 'type' : '".$type."' }";

//echo $query;


function toPerson( $address, $conn, $table )
{
	$table = $conn->query( "SELECT user, domain, nick FROM ".$table );
	while ( $row = mysqli_fetch_array( $table ) )
	{
		if ( $row['user'].'@'.$row['domain'] == $address ) return $row['nick'];
	}
	return $address;
}

if ( file_exists( "../promenne.php" ) && require( "../promenne.php" ) )
{
	if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
	{
		echo '<div id="stateBar">';
		if ( $type == 'inBox' || $type == 'nonReat' )
			echo '<button class="stateBar"><img src="img/setToReat.png" alt="Přečtené" title="Přečtené" onclick="mailsToReatAll( \'selectMail[]\', \''.$where.'\', \''.str_replace( "'", "\'", $query ).'\', '.$info.', \''.$_POST['name'].'\', \''.$_POST['domain'].'\' )" ></button>';
		if ( $type == 'inBox' || $type == 'nonReat' )
			echo '<button class="stateBar"><img src="img/setToUnreat.png" alt="Nepřečtené" title="Nepřečtené" onclick="mailsToUnreatAll( \'selectMail[]\', \''.$where.'\', \''.str_replace( "'", "\'", $query ).'\', '.$info.', \''.$_POST['name'].'\', \''.$_POST['domain'].'\' )" ></button>';
		if ( $type == 'binBox' || $type == 'spamBox' )
			echo '<button class="stateBar"><img src="img/inBox.png" alt="Do doručených" title="Do doručených" onclick="backToInBoxAll( \'selectMail[]\', \''.$where.'\', \''.str_replace( "'", "\'", $query ).'\', '.$info.', \''.$_POST['name'].'\', \''.$_POST['domain'].'\' )" ></button>';
		if ( $type == 'nonReat' || $type == 'inBox' || $type == 'binBox' )
			echo '<button class="stateBar"><img src="img/spam.png" alt="Spam" title="Spam" onclick="mailToSpamAll( \'selectMail[]\', \''.$where.'\', \''.str_replace( "'", "\'", $query ).'\', '.$info.', \''.$_POST['name'].'\', \''.$_POST['domain'].'\' )" ></button>';
		if ( $type == 'nonReat' || $type == 'inBox' || $type == 'spamBox' )
			echo '<button class="stateBar"><img src="img/toBin.png" alt="Do koše" title="Do koše" onclick="mailToBinAll( \'selectMail[]\', \''.$where.'\', \''.str_replace( "'", "\'", $query ).'\', '.$info.', \''.$_POST['name'].'\', \''.$_POST['domain'].'\' )" ></button>';
		if ( $type == 'outBox' || $type == 'binBox' || $type == 'spamBox' )
			echo '<button class="stateBar"><img src="img/delete.png" alt="Smazat" title="Smazat" onclick="mailDeleteAll( \'selectMail[]\', \''.$where.'\', \''.str_replace( "'", "\'", $query ).'\', '.$info.', \''.$type.'\', \''.$_POST['name'].'\', \''.$_POST['domain'].'\' )" ></button>';
		echo '</div>';
		
		$table = $conn->query( $query );
		echo '<table rules="none" id="resultBoxTable">';
		echo '<tr class="resultBoxRow">';
		echo '<th class="mailCol0"><input type="checkbox" title="Select all" onclick="selectAll( \'selectMail[]\', \'stateBar\' )" /></th>';
		$i = 0;
		for ( $i = 0; $i < mysqli_num_fields( $table ) - $shift; ++$i )
		{
			$cell = mysqli_fetch_field( $table );
			if ( $bolt && $i ) echo '<th class="resultBoxCell mailCol'.$i.'">'.$cell->name.'</th>';
		}
		echo '</tr>';
		
		
		
		while ( $row = mysqli_fetch_array( $table, MYSQLI_NUM ) )
		{
			$i = 0;
			echo '<tr class="resultBoxRow">';
			echo '<td class="resultBoxCell mailCol0"><input type="checkbox" name="selectMail[]" value="'.$row[0].'" /></td>';
			//echo $row[0];
			for ( $ii = 1; $ii < count($row) - $shift; ++$ii )
			{
				$cell = $row[ $ii ];
				echo '<td class="resultBoxCell mailCol'.(++$i); 
				if ( $ii == 1 && !$row[ mysqli_num_fields( $table )-1 ] ) echo ' notReatYet"';
				echo '" onclick="viewMessage( \''.$where.'\', '.$row[0].', \''.str_replace( "'", '\\\'', $query ).'\', '.$info.', \''.$_POST['name'].'\', \''.$_POST['domain'].'\' )"><span>';
				echo $ii == 1 ? toPerson( $cell, $conn, $db_users ) : substr( $cell, 0, $maxMessLen ).( strlen($cell) > $maxMessLen ? '...' : '' );
				echo '</span></td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		mysqli_close( $conn );
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../promenne.php doesn't exists.</p>";
?>
<?php
$query = $_REQUEST['query'];
$promenneFile = "../../../promenne.php";

if ( file_exists( $promenneFile ) && require $promenneFile ) { 
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query("SET CHARACTER SET UTF8") ) {

		
		$sql = $spojeni->query( 'SHOW KEYS FROM utrata_members WHERE Key_name = "PRIMARY"' );
		$keys = mysqli_fetch_array( $sql );
		$key = $keys['Column_name'];
		
		$cnt = 0;
		$sql = $spojeni->query( $query );
		echo '<table rules="all" id="printAllPeople">';
		echo '<tr>';
		while ( $head = mysqli_fetch_field($sql) ) {
			echo '<th>'.$head->name.'</th>';
			$cnt++;
		}
		echo '<th>Del</th></tr>';
		while ( $row = mysqli_fetch_array( $sql ) ) {
			echo '<tr>';
			for ( $i = 0; $i < $cnt; $i++ ) {
				echo '<td>'.$row[$i].'</td>';
			}
			echo '<td><button onClick="delConcrPerson( \''.$row['name'].'\' )">Del</button></td></tr>';
		}
		
	} else echo "<h2>Connection with database had failed.</h2>";
} else echo "<h2>File $promenneFile doesn't found.</h2>";
?>
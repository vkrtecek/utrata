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
		
		$head = array();
		$title = array();
		while ( $tmp = mysqli_fetch_field( $sql ) ){
			$head[$cnt] = $tmp->name;
			$title[$cnt] = $tmp->type;
			$cnt++;
		}
		
		echo '<table rules="all" id="printAllPeople">';
		echo '<tr>';
		for ( $i = 0; $i < count($head); $i++ ) {
			echo '<th title="'.$title[$i].'">'.$head[$i].'</th>';
		}
		$CNT2 = 0;
		echo '</tr>';
		while ( $row = mysqli_fetch_array( $sql ) ) {
			++$CNT2;
			echo '<tr>';
			for ( $i = 0; $i < $cnt; $i++ ) {
				echo '<td id="'.$head[$i].($CNT2).'" onDblClick="updateCell( \''.$head[$i].($CNT2).'\', \''.$head[$i].'\', \''.$row['name'].'\' )">'.$row[$i].'</td>';
			}
			echo '</tr>';
		}
		
	} else echo "<h2>Connection with database had failed.</h2>";
} else echo "<h2>File $promenneFile doesn't found.</h2>";
?>
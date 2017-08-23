<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Make standart date format</title>
</head>
<body>
<?php
$openFile = "../promenne.php";

if ( file_exists( $openFile ) && require( $openFile ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		function makeStandardDateFormat( $in )
		{
			list( $date, $time ) = explode( '|', $in );
			if ( !isset($time) )
			{
				echo "(".$date.") -> !isset(time) after '|' ---- ";
				return false;
			}
			list( $day, $rest ) = explode( '.', $date );
			if ( !isset($rest) )
			{
				echo "(".$day.")!isset(reset) after '.' ---- ";
				return false;
			}
			$rest = trim($rest);
			list( $month, $year ) = explode( ' ', $rest );
			if ( !isset($year) )
			{
				echo "[".$rest."] --- "."(".$month.") -> !isset(year) after ' ' ---- ";
				return false;
			}
			switch( $month )
			{
				case 'leden':
					$month = '01';
					break;
				case 'únor':
					$month = '02';
					break;
				case 'březen':
					$month = '03';
					break;
				case 'duben':
					$month = '04';
					break;
				case 'květen':
					$month = '05';
					break;
				case 'červen':
					$month = '06';
					break;
				case 'červenec':
					$month = '07';
					break;
				case 'srpen':
					$month = '08';
					break;
				case 'září':
					$month = '09';
					break;
				case 'říjen':
					$month = '10';
					break;
				case 'listopad':
					$month = '11';
					break;
				case 'prosinec':
					$month = '12';
					break;
				default:
					echo "!isset(month) ---- ";
					return false;
				
			}
			return trim($year).'-'.trim($month).'-'.trim($day).' '.trim($time);
		}
		
		if ( !isset($_REQUEST['OK']) || $_REQUEST['id'] == '' || $_REQUEST['date'] == '' || $_REQUEST['table'] == '' )
		{
			echo '<form method="get">';
			echo '<label for="id">id </label><input type="text" name="id" id="id" value="'.( isset($_REQUEST['id']) ? $_REQUEST['id'] : '' ).'" /><br />';
			echo '<label for="date">date </label><input type="text" name="date" id="date" value="'.( isset($_REQUEST['date']) ? $_REQUEST['date'] : '' ).'" /><br />';
			echo '<label for="table">table </label><input type="text" name="table" id="table" value="'.( isset($_REQUEST['table']) ? $_REQUEST['table'] : '' ).'" /><br />';
			echo '<button name="OK">OK</button>';
			echo '</form>';
		}
		else
		{
			$id = $_REQUEST['id'];
			$date = $_REQUEST['date'];
			$table = $_REQUEST['table'];
			
			$sql = $spojeni->query( "SELECT $id, $date FROM $table" );
			$i = 0;
			while( $row = mysqli_fetch_array($sql) )
			{
				//if ( $i++ == 1 ) break;
				if ( !($newDate = makeStandardDateFormat( $row[$date] )) )
				{
					echo 'Fail in '.$id.' = '.$row[$id].' <strong>'.$row[$date].'</strong><br />';
					continue;
				}
				$spojeni->query( "UPDATE $table SET $date = '$newDate' WHERE $id = '$row[$id]'" );
				echo "UPDATE $table SET $date = '$newDate' WHERE $id = '$row[$id]' <br/>";
			}
			
			echo '<form method="get"><button>back</button></form>';
		}
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $openFile doesn't exists</p>";
?>
<script type="text/javascript">
var tables = document.getElementsByClassName( 'xdebug-error xe-notice' );
for ( var i = 0; i < tables.length; ++i )
{
	document.getElementsByClassName( 'xdebug-error xe-notice' )[i].style.display = 'none';
}
</script>
</body>
</html>
<?php
$prikaz = $_REQUEST['prikaz'];
$table = $_REQUEST['table'];
$where = $_REQUEST['where'];
$platnost = $_REQUEST['platnost'];
//echo $prikaz;

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$arr = explode( '_', $table );
		$who = $arr[1];
		$sql = $spojeni->query( 'SELECT value FROM utrata_members M LEFT JOIN utr_currencies C ON M.currencyID=C.CurrencyID WHERE M.name = "'.$who.'"' );
		$sql = mysqli_fetch_array( $sql );
		$currency = $sql['value'];
		
		
		$sql = $spojeni->query( $prikaz );
		$prikaz = str_replace( '"', "\\'", $prikaz );
		echo '<strong><table rules="none" id="popis"><tr><td class="nazev">Název položky</td><td class="popis">Bližší popis</td><td class="pozn">Poznámka</td><td class="typ">Typ</td><td class="cena">Celková cena</td></tr></table></strong>';
		$items_count = 0;
		$suma = 0;
		while ( $item = mysqli_fetch_array( $sql ) )
		{
			$price = $item['cena'] * $item['kurz'];
			$each_item = '<div class="item';
			if ( !$platnost ) $each_item .= '_old';
			if ( $item['odepsat'] == 1 ) $each_item .= ' moje_utrata';
			$each_item .= '">';
			$each_item .= "<button title=\"Delete\" class=\"smazat_prispevek\" onclick=\"deleteItem( ".$item['ID'].", '".$table."', '".$where."'".( !$platnost ? ', 0' : '' )." )\"><b>×</b></button>";
			if ( $platnost ) $each_item .= "<button title=\"Check\" class=\"aktualizovat_prispevek\" onclick=\"updateItem( ".$item['ID'].", '".$table."', '".$where."' )\"><b>✓</b></button>";
			$each_item .= '<table rules="none"><tr>';
			$each_item .= '<td class="nazev red"><h2>'.$item['nazev'].'</h2></td>';
			$each_item .= '<td class="popis">'.str_replace( '
', '<br />', $item['popis'] ).'</td>';
			$each_item .= '<td class="pozn"><em>('.$item['pozn'].')</em></td>';
			$each_item .= '<td class="typ">'.$item['typ'].'</td>';
			$each_item .= '<td class="cena"><strong>'.number_format((float)$price, 2, ',', ' ').' '.$currency.'</strong></td>';
			$each_item .= '</tr></table>';
			$each_item .= '<p><strong>'.dateToReadableFormat($item['datum']).'</strong></p>';
			$each_item .= '</div>';
			echo $each_item;
			
			$items_count++;
			$suma += $item['cena']; 
		}
		if ($items_count == 0) echo '<div id="count">Takovému výběru neodpovídají žádné výsledky.</div>';
		else echo '<table rules="none"><tr><td class="nazev">Celkem položek: '.number_format((float)$items_count, 0, ',', ' ').'</td><td class="popis"></td><td class="pozn"></td><td class="typ"></td><td class="cena">SUM: '.number_format((float)$suma, 2, ',', ' ').' '.$currency.'</td></tr></table>';
		
	}
	else echo "<p>Connection failed.</p>";
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>";
?>
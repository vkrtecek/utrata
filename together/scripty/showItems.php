<?php
$prikaz = $_REQUEST['prikaz'];
$user = $_REQUEST['user'];
$where = $_REQUEST['where'];
$platnost = $_REQUEST['platnost'];
//echo $prikaz;

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$months = array(
			translateByCode( $spojeni, 'name', $user, 'Month.January' ),
			translateByCode( $spojeni, 'name', $user, 'Month.February' ),
			translateByCode( $spojeni, 'name', $user, 'Month.March' ),
			translateByCode( $spojeni, 'name', $user, 'Month.April' ),
			translateByCode( $spojeni, 'name', $user, 'Month.May' ),
			translateByCode( $spojeni, 'name', $user, 'Month.June' ),
			translateByCode( $spojeni, 'name', $user, 'Month.July' ),
			translateByCode( $spojeni, 'name', $user, 'Month.August' ),
			translateByCode( $spojeni, 'name', $user, 'Month.September' ),
			translateByCode( $spojeni, 'name', $user, 'Month.October' ),
			translateByCode( $spojeni, 'name', $user, 'Month.November' ),
			translateByCode( $spojeni, 'name', $user, 'Month.December' )
		);
		
		
		$sql = $spojeni->query( 'SELECT value FROM utrata_members M LEFT JOIN utr_currencies C ON M.currencyID=C.CurrencyID WHERE M.name = "'.$user.'"' );
		$sql = mysqli_fetch_array( $sql );
		$currency = $sql['value'];
		
		
		$sql = $spojeni->query( $prikaz );
		$prikaz = str_replace( '"', "\\'", $prikaz );
		echo '<strong>';
		if ( $platnost ) echo '<button title="'.translateByCode($spojeni, 'name', $user, 'ShowItems.CheckAll.Title').'" class="aktualizovat_prispevek" onclick="updateAllItems( \''.$user.'\', \''.$where.'\', \''.translateByCode($spojeni, 'name', $user, 'ShowItems.CheckAll.Alert').'\' )"><b>&#10004;</b></button>';
echo '<table rules="none" id="popis">
			<tr>
				<td class="nazev">'.translateByCode($spojeni, 'name', $user, 'PrintItems.Name').'</td>
				<td class="popis">'.translateByCode($spojeni, 'name', $user, 'PrintItems.Description').'</td>
				<td class="pozn">'.translateByCode($spojeni, 'name', $user, 'PrintItems.Note').'</td>
				<td class="typ">'.translateByCode($spojeni, 'name', $user, 'PrintItems.Type').'</td>
				<td class="cena">'.translateByCode($spojeni, 'name', $user, 'PrintItems.Price').'</td>
			</tr>
		</table>
	</strong>';
		$items_count = 0;
		$suma = 0;
		while ( $item = mysqli_fetch_array( $sql ) )
		{
			$price = $item['cena'] * $item['kurz'];
			$each_item = '<div id="itemDiv_'.$item['ID'].'" class="item';
			if ( !$platnost ) $each_item .= '_old';
			if ( $item['odepsat'] == 1 ) $each_item .= ' moje_utrata';
			$each_item .= '">';
			$each_item .= "<button title=\"".translateByCode($spojeni, 'name', $user, 'PrintItems.DeleteItemTitle')."\" class=\"smazat_prispevek\" onclick=\"deleteItem( ".$item['ID'].", '".$user."', '".$where."', 'prostred', '".translateByCode($spojeni, 'name', $user, 'ShowItems.Delete.Alert')."'".( !$platnost ? ', 0' : '' )." )\"><b>&times;</b></button>";
			if ( $platnost ) $each_item .= "<button title=\"".translateByCode($spojeni, 'name', $user, 'PrintItems.CheckedItemTitle')."\" class=\"aktualizovat_prispevek\" onclick=\"updateItemRead( ".$item['ID'].", '".$user."', '".$where."' )\"><b>&#10004;</b></button>";
			if ( $platnost ) $each_item .= '<button title="'.translateByCode($spojeni, 'name', $user, 'PrintItems.UpdateItemTitle').'" class="updateItem" onclick="updateItemMakeForm( '.$item['ID'].', \''.$user.'\', \''.$where.'\', \'prostred\', \'itemDiv_'.$item['ID'].'\', \''.translateByCode($spojeni, 'name', $user, 'UpdateItem.AlreadyUpdating').'\' )"></button>';
			$each_item .= '<table rules="none"><tr>';
			$each_item .= 	'<td class="nazev red"><h2>'.$item['nazev'].'</h2></td>';
			$each_item .= 	'<td class="popis">'.str_replace( '
', '<br />', $item['popis'] ).'</td>';
			$each_item .= 	'<td class="pozn"><em>('.$item['value'].')</em></td>';
			$each_item .= 	'<td class="typ">'.$item['typ'].'</td>';
			$each_item .= 	'<td class="cena"><strong>'.number_format((float)$price, 2, ',', ' ').' '.$currency.'</strong></td>';
			$each_item .= '</tr></table>';
			$each_item .= '<p><strong>'.dateToReadableFormat($item['datum'], $months).'</strong></p>';
			$each_item .= '</div>';
			echo $each_item;
			
			$items_count++;
			$suma += $item['cena']; 
		}
		if ($items_count == 0) echo '<div id="count">'.translateByCode($spojeni, 'name', $user, 'PrintItems.NoResults').'</div>';
		else echo '<table rules="none"><tr><td class="nazev">'.translateByCode($spojeni, 'name', $user, 'PrintItems.TotalItemsSize').': '.number_format((float)$items_count, 0, ',', ' ').'</td><td class="popis"></td><td class="pozn"></td><td class="typ"></td><td class="cena">'.translateByCode($spojeni, 'name', $user, 'PrintItems.TotalItemsPrice').': '.number_format((float)$suma, 2, ',', ' ').' '.$currency.'</td></tr></table>';
		
	}
	else echo "<p>Connection failed.</p>";
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>";
?>

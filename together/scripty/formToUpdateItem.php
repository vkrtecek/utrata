<?php
$id = $_REQUEST['id'];
$user = $_REQUEST['user'];
$where = $_REQUEST['where'];
$whereStatus = $_REQUEST['whereStatus'];

if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$cardBack = translateByCode($spojeni, 'name', $user, 'PrintItems.PayedBy.Card' );
		$cashBack = translateByCode($spojeni, 'name', $user, 'PrintItems.PayedBy.Cash' );
		$card = translateByCode($spojeni, 'name', $user, 'AddItem.Form.Type.Card' );
		$cash = translateByCode($spojeni, 'name', $user, 'AddItem.Form.Type.Cash' );
		
		$sqlItem = $spojeni->query( "SELECT * FROM utrata_items USER LEFT JOIN utrata_Purposes P ON USER.pozn=P.PurposeID WHERE ID=".$id );
		$sqlCurrency = $spojeni->query( "SELECT * FROM utr_currencies WHERE CurrencyID=(SELECT currencyID FROM utrata_members WHERE name='".$user."')" );
		$sqlPurposes = $spojeni->query( "SELECT * FROM utrata_Purposes WHERE PurposeID IN (SELECT PurposeID FROM utrata_UserPurposes WHERE UserID='".$user."')" );
		$sqlCurrencies = $spojeni->query( "SELECT * FROM utr_currencies" );
		$item = mysqli_fetch_array( $sqlItem, MYSQLI_ASSOC );
		$tmpCurrency = mysqli_fetch_array( $sqlCurrency, MYSQLI_ASSOC );
		$myCurrency = $tmpCurrency['value'];
		$myCurrencyCode = $tmpCurrency['code'];
		

		$print = '<div id="updateDiv">'; 
		$print .= '<button title="'.translateByCode($spojeni, 'name', $user, 'UpdateItem.Storno').'" class="updateButtonStorno" onclick="updateItem( 0, \''.$where.'\', \''.$user.'\' )"></button>';
		$print .= '<button title="'.translateByCode($spojeni, 'name', $user, 'UpdateItem.Update').'" class="updateButtonSave" onclick="updateItem( 1, \''.$where.'\', \''.$user.'\', \''.$whereStatus.'\', '.$id.' )"></button>';
		$print .= '<table rules="none"><tr>';
		$print .= 	'<td class="nazev"><input type="text" id="updateName" value="'.$item['nazev'].'" /></td>';
		$print .= 	'<td class="popis"><textarea id="updateDesc">'.str_replace( '
', '<br />', $item['popis'] ).'</textarea></td>';
		$print .= 	'<td class="pozn">';
		$print .= 		'<select id="updatePurpose">';
		while ($purpose = mysqli_fetch_array($sqlPurposes, MYSQLI_ASSOC))
			$print .=			'<option value="'.$purpose['PurposeID'].'" '.($purpose['PurposeID'] == $item['pozn'] ? 'selected=""' : '').'>'.$purpose['value'].'</option>';
		$print .= 		'</select>';
		$print .=		'</td>';
		$print .=		'<td class="typ">';
		$print .= 		'<select id="updateType">';
		$print .=				'<option value="'.$cardBack.'" '.($item['typ'] == $cardBack ? 'selected="selected"' : '').'>'.$card.'</option>';
		$print .= 			'<option value="'.$cashBack.'" '.($item['typ'] == $cashBack ? 'selected="selected"' : '').'>'.$cash.'</option>';
		$print .= 		'</select>';
		$print .= 	'</td>';
		$print .= 	'<td class="cena">';
		$print .= 		'<input style="width:60px;" type="number" step="0.01" id="updatePrice" value="'.number_format((float)$item['cena'], 2, '.', ' ').'" />';
		$print .=			'<select id="updateCurrency" onChange="getCourseValue( \''.$myCurrencyCode.'\', \'updateCourse\', this )">';
		while ( $currency = mysqli_fetch_array( $sqlCurrencies, MYSQLI_ASSOC) )
			$print .=			'<option value="'.$currency['code'].'" '.($currency['value'] == $myCurrency ? 'selected=""' : '').'>'.$currency['value'].'</option>';
		$print .=			'</select>';
		$print .=			'<span id="updateCurrencySpan">&nbsp;'.translateByCode($spojeni, 'name', $user, 'AddItem.Form.CurrencyCourse').'&nbsp;<input type="number" step="0.0001" style="width:70px;" id="updateCourse" value="1" /></span>';
		$print .=		'</td>';
		$print .= '</tr></table>';
		$print .= '</div>';
		$print .= '<p>';
		$print .=		'<input type="datetime-local" id="updateDate" value="'.toDefaultTime($item['datum']).'" />';
		$print .=		'&nbsp;|&nbsp;';
		$print .=		'<input type="checkbox" id="updateOdepsat" '.($item['odepsat'] == 1 ? 'checked' : '').' />&nbsp;<label for="updateOdepsat">'.translateByCode($spojeni, 'name', $user, 'AddItem.Form.MyExpense').'</label>';
		$print .=	'</p>';

		
		echo $print;
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../../promenne.php doesn't exist.</p>"
?>
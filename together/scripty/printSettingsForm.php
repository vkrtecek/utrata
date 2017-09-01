<?php
$login = $_REQUEST['login'];
	
function inArray( $arr, $item ) {
	foreach ( $arr as $a )
		if ( $a == $item ) return true;
	return false;
}
	
if ( file_exists( "../../../promenne.php" ) && require( "../../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name ) ) && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		$st = "SELECT * FROM utrata_members WHERE login='".$login."'";
		$sql = $spojeni->query( $st );
		$person = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		
		$sqlCurrencies = $spojeni->query( "SELECT * FROM utr_currencies" );
		
		echo '<table rules="none">
			<tr>
				<td>
					<label for="name">Jméno</label>
				</td>
				<td>
					<input disabled type="text" id="name" value="'.$person['name'].'" goodValue="'.$person['name'].'" onKeyUp="makeLowercase( this ); checkExistenceInCol( this, \'name\', \'warningName\' );" /><strong id="warningName"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="login">Login</label>
				</td>
				<td>
					<input type="text" id="login" value="'.$person['login'].'" goodValue="'.$person['login'].'" onKeyUp="makeLowercase( this ); checkExistenceInCol( this, \'login\', \'warningLogin\' );" /><strong id="warningLogin"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="passwd">Heslo</label>
				</td>
				<td>
					<input type="password" id="passwd" value="'.$person['passwd'].'" goodValue="'.$person['passwd'].'" onKeyUp="checkPasswd( this, \'warningPass1\', false );" /><strong id="warningPass1"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="passwd2">Heslo znova</label>
				</td>
				<td>
					<input type="password" id="passwd2" value="'.$person['passwd'].'" goodValue="'.$person['passwd'].'" onKeyUp="checkPasswd( this, \'warningPass2\', true );" /><strong id="warningPass2"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="SendByOne">Posílat rodiči každou položku</label>
				</td>
				<td>
					<select id="SendByOne">
						<option value="1" '.($person['sendByOne'] == 1 ? 'selected=""' : '').'>ANO</option>
						<option value="0" '.($person['sendByOne'] == 0 ? 'selected=""' : '').'>NE</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="SendMonthly">Možnost posílat měsíční výpis</label>
				</td>
				<td>
					<select id="SendMonthly">
						<option value="1" '.($person['sendMonthly'] == 1 ? 'selected=""' : '').'>ANO</option>
						<option value="0" '.($person['sendMonthly'] == 0 ? 'selected=""' : '').'>NE</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="motherMail">Mail na rodiče</label>
				</td>
				<td>
					<input type="text" id="motherMail" value="'.$person['mother'].'" goodValue="'.$person['mother'].'" onKeyUp="checkMail( this, \'warningMother\');" /><strong id="warningMother"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="meMail">Mail na mě</label>
				</td>
				<td>
					<input type="text" id="meMail" value="'.$person['me'].'" goodValue="'.$person['me'].'" onKeyUp="checkMail( this, \'warningMe\');" /><strong id="warningMe"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="currency">Měna</label>
				</td>
				<td>
					<select id="currency">';
					while ( $curr = mysqli_fetch_array($sqlCurrencies, MYSQLI_ASSOC) ) {
						echo '<option value="'.$curr['CurrencyID'].'" '.($curr['CurrencyID']==$person['currencyID'] ? 'selected=""' : '').'>'.$curr['name'].'</option>';
					}
		echo '</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="purposes">Druhy útraty</label>
				</td>
				<td>
					<select id="purposes" multiple="multiple">';
					$st = "SELECT * FROM utrata_members M LEFT JOIN utrata_UserPurposes UP ON M.name=UP.UserID LEFT JOIN utrata_Purposes P ON UP.PurposeID=P.PurposeID WHERE M.login='".$login."'";
					$sqlUserPurpose = $spojeni->query( $st );
					$arr = array();
					while ( $userPurpose = mysqli_fetch_array($sqlUserPurpose, MYSQLI_ASSOC)) {
						array_push($arr, $userPurpose['code'] );
					}
					$st = "SELECT * FROM utrata_Purposes";
					$sqlPurposes = $spojeni->query( $st );
					while( $purpose = mysqli_fetch_array($sqlPurposes, MYSQLI_ASSOC) ) {
						echo '<option value="'.$purpose['code'].'" ';
						if ( inArray($arr, $purpose['code']) ) echo 'selected=""';
						echo '>'.$purpose['value'].'</option>';
					}
		echo '</select>
				</td>
			</tr>
			<tr>
				<td>
					<button onClick="changeSettings()">Změnit</button>
				</td>
				<td>
					<input type="hidden" id="settingsID" value="'.$person['name'].'" />
				</td>
			</tr>
		</table>';
	} else echo '<p>Connection failed.</p>';
} else echo "<p>File ../../../promenne.php doesn't exists.</p>";
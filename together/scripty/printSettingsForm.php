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
		$st = "SELECT * FROM utr_languages";
		$sqlLanguages = $spojeni->query( $st );
		
		$st = "SELECT * FROM utrata_members WHERE login='".$login."'";
		$sql = $spojeni->query( $st );
		$person = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		
		$sqlCurrencies = $spojeni->query( "SELECT * FROM utr_currencies" );
		
		
		echo '<table rules="none">
			<tr>
				<td>
					<label for="name">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.Name').'</label>
				</td>
				<td>
					<input disabled type="text" id="name" value="'.$person['name'].'" goodValue="'.$person['name'].'" onKeyUp="makeLowercase( this ); checkExistenceInCol( this, \'name\', \'warningName\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Login.TooShort').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Login.AlreadyExists').'\' );" /><strong id="warningName"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="login">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.Login').'</label>
				</td>
				<td>
					<input type="text" id="login" value="'.$person['login'].'" goodValue="'.$person['login'].'" onKeyUp="makeLowercase( this ); checkExistenceInCol( this, \'login\', \'warningLogin\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Login.TooShort').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Login.AlreadyExists').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Login.SomeError').'\' );" /><strong id="warningLogin"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="passwd">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.Password').'</label>
				</td>
				<td>
					<input type="password" id="passwd" value="'.$person['passwd'].'" goodValue="'.$person['passwd'].'" onKeyUp="checkPasswd( this, \'warningPass1\', false, \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Password.TooShort').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Password.BadSecurity').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.ConfirmPassword.NotSame').'\' );" /><strong id="warningPass1"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="passwd2">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.ConfirmPassword').'</label>
				</td>
				<td>
					<input type="password" id="passwd2" value="'.$person['passwd'].'" goodValue="'.$person['passwd'].'" onKeyUp="checkPasswd( this, \'warningPass2\', true, \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Password.TooShort').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Password.BadSecurity').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.ConfirmPassword.NotSame').'\' );" /><strong id="warningPass2"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="SendByOne">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.SendByOne').'</label>
				</td>
				<td>
					<select id="SendByOne">
						<option value="1" '.($person['sendByOne'] == 1 ? 'selected=""' : '').'>'.translateByCode($spojeni, 'login', $login, 'Yes').'</option>
						<option value="0" '.($person['sendByOne'] == 0 ? 'selected=""' : '').'>'.translateByCode($spojeni, 'login', $login, 'No').'</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="SendMonthly">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.SendMonthly').'</label>
				</td>
				<td>
					<select id="SendMonthly">
						<option value="1" '.($person['sendMonthly'] == 1 ? 'selected=""' : '').'>'.translateByCode($spojeni, 'login', $login, 'Yes').'</option>
						<option value="0" '.($person['sendMonthly'] == 0 ? 'selected=""' : '').'>'.translateByCode($spojeni, 'login', $login, 'No').'</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="motherMail">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.MailToParent').'</label>
				</td>
				<td>
					<input type="text" id="motherMail" value="'.$person['mother'].'" goodValue="'.$person['mother'].'" onKeyUp="checkMail( this, \'warningMother\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Mail.BadFormat').'\' );" /><strong id="warningMother"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="meMail">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.MailToMe').'</label>
				</td>
				<td>
					<input type="text" id="meMail" value="'.$person['me'].'" goodValue="'.$person['me'].'" onKeyUp="checkMail( this, \'warningMe\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Mail.BadFormat').'\' );" /><strong id="warningMe"></strong>
				</td>
			</tr>
			<tr>
				<td>
					<label for="currency">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.Currency').'</label>
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
					<label for="language">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.Language').'</label>
				</td>
				<td>
					<select id="language" onchange="redrawPurposesByLanguage( this )">';
					while ( $lang = mysqli_fetch_array($sqlLanguages, MYSQLI_ASSOC) ) {
						echo '<option value="'.$lang['LanguageCode'].'" '.($lang['LanguageCode']==$person['LanguageCode'] ? 'selected=""' : '').'>'.$lang['Name'].'</option>';
					}
		echo '</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="purposes">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.KindsOfSpend').'</label>
				</td>
				<td>
					<select id="purposes" multiple="multiple">';
					$st = "SELECT * FROM utrata_members M LEFT JOIN utrata_UserPurposes UP ON M.name=UP.UserID LEFT JOIN utrata_Purposes P ON UP.PurposeID=P.PurposeID WHERE M.login='".$login."'";
					$sqlUserPurpose = $spojeni->query( $st );
					$arr = array();
					while ( $userPurpose = mysqli_fetch_array($sqlUserPurpose, MYSQLI_ASSOC)) {
						array_push($arr, $userPurpose['code'] );
					}
					$st = "SELECT * FROM utrata_Purposes WHERE LanguageCode='".$person['LanguageCode']."'";
					$sqlPurposes = $spojeni->query( $st );
					while( $purpose = mysqli_fetch_array($sqlPurposes, MYSQLI_ASSOC) ) {
						echo '<option value="'.$purpose['code'].'" ';
						if ( inArray($arr, $purpose['code']) ) echo 'selected=""';
						echo '>'.$purpose['value'].'</option>';
					}
		echo '</select>
				<div id="addPurpose">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.KindOfSpend.AddNew').': <div class="bordered"><input type="text" id="newPurpose" /><button onclick="addPurpose( \'newPurpose\', \'purposes\', \'status\', \''.$person['LanguageCode'].'\' )">+</button></div></div>
				</td>
			</tr>
			<tr>
				<td>
					<button onClick="changeSettings( \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Alert.Name').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Alert.Login').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Alert.Password').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Alert.PasswordAgain').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Alert.MailToParent').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Alert.MailToMe').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Result.Error').'\', \''.translateByCode($spojeni, 'login', $login, 'Settings.Form.Result.Success').'\' )">'.translateByCode($spojeni, 'login', $login, 'Settings.Form.Send').'</button>
				</td>
				<td>
					<input type="hidden" id="settingsID" value="'.$person['name'].'" />
				</td>
			</tr>
		</table>';
	} else echo '<p>Connection failed.</p>';
} else echo "<p>File ../../../promenne.php doesn't exists.</p>";
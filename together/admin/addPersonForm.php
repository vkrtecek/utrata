<table rules="none" id="addUser">
	<tr>
    	<td>
            <label for="insName">Name (PK of table): </label>
        </td>
        <td>
            <input id="insName" name="" onKeyUp="checkUserExistence( 'insName', 'userExistenceHere' )" value="" /><span id="userExistenceHere"></span>
        </td>
    </tr>
    <tr>
    	<td>
            <label for="insLogin" >Login: </label>
        </td>
        <td>
        	<input id="insLogin" name="" onKeyUp="checkLoginExistence( 'insLogin', 'loginExistenceHere' )" value="" /><span id="loginExistenceHere"></span>
        </td>
    </tr>
    <tr>
    	<td>
            <label for="insPasswd">Password: </label>
        </td>
        <td>
        	<input type="password" id="insPasswd" name="" value="" />
        </td>
    </tr>
    <tr>
    	<td>
            <label for="insSendMonthly">Enable send mothly preview to parent: </label>
        </td>
        <td>
            <select id="insSendMonthly">
            	<option value="1" selected>YES</option>
                <option value="0">NO</option>
            </select>
        </td>
    </tr>
    <tr>
    	<td>
            <label for="insSendByOne">Enable send every entry to parent: </label>
        </td>
        <td>
        	<select id="insSendByOne">
            	<option value="1" selected>YES</option>
                <option value="0">NO</option>
            </select>
        </td>
    </tr>
    <tr>
    	<td>
            <label for="insMother">Mail to parent: </label>
        </td>
        <td>
        	<input id="insMother" name="" value="" />
        </td>
    </tr>
    <tr>
    	<td>
            <label for="insMe">Mail to user: </label>
        </td>
        <td>
        	<input id="insMe" name="" value="" />
        </td>
    </tr>
    <tr>
    	<td>
            <label for="insCurrency">Currency: </label>
        </td>
        <td>
        	<select id="insCurrency">
          	<?php
							require( "../../../promenne.php" );
							$spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name );
							if ( $spojeni->query( "SET CHARACTER SET UTF8" ) ) {
								$sql = $spojeni->query( "SELECT * FROM utr_currencies" );
								while ( $currency = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
									echo '<option value="'.$currency['CurrencyID'].'">'.$currency['name'].' ('.$currency['value'].')'.'</option>';
								}
							}
						?>
          </select> 
        </td>
    </tr>
    <tr>
    	<td colspan="2">
            <button onclick="checkAdding( 'addUserOutput' )">Add</button>
        </td>
    </tr>
</table>

<div id="addUserOutput"></div>
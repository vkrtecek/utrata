<?php
function printListOfDomains()
{
	if ( file_exists( "promenne.php" ) && require( "promenne.php" ) )
	{
		if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
		{
			$table = $conn->query( "SELECT * FROM ".$db_domains." WHERE inUse = 1" );
			while ( $row = mysqli_fetch_array( $table ) )
			{
				echo '<option value="'.$row['domain'].'" '.( isset($_POST['domain']) && $_POST['domain'] == $row['domain'] ? 'selected=""' : '' ).'>'.$row['domain'].'</option>';
			}
		}
		else echo '<option>Connnection failed.</option>';
	}
	else echo "<option>File promenne.php doesn't exists.</option>";
}?>




<form id="formSignIn" method="post" >
	<table rules="none" id="tableSignIn">
		<tr><td>
        	E-mail:
        </td><td>
        	<input name="name" type="text" value="<?php if ( isset($_POST['name']) ) echo $_POST['name']; ?>" id="focus" />
        </td><td>
        	<select name="domain">
            	<?php 
					printListOfDomains();
				?>
            </select>
        </td></tr>
    	<tr><td>
        	Heslo:
        </td><td>
        	<input name="passwd" type="password" value="" />
        </td><td rowspan="2">
        	<span id="registration"><a href="registration.php" onMouseDown="underline(this)" onMouseUp="ununderline(this)" title="Register as a new user">Registrovat se</a></span><br />
            <span id="lostPasswd"><a href="lostPasswd.php" onMouseDown="underline(this)" onMouseUp="ununderline(this)" title="Set new password">Zapomenuté heslo<a></span>
        </td></tr>
        <tr><td colspan="2">
        	<input type="submit" name="submit" value="Přihlásit" />
        </td></tr>
        <tr><td colspan="3"><?php if ( isset($_POST['submit']) ) echo '<span class="red">Špatné údaje</span>'; ?></td></tr>
    </table>
</form>
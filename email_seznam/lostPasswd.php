<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="styly/styles.css" media="all" />
    <link rel="stylesheet" type="text/css" href="styly/baseColor.css" media="all" />
    <link rel="stylesheet" type="text/css" href="styly/lostPasswd.css" media="all" />
<title>Zapomenuté heslo</title>
</head>
<body>
<?php
if ( file_exists( "promenne.php" ) && require( "promenne.php" ) )
{
	if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
	{
		
		
		$warning1 = $warning2 = $warning3 = true;
		if ( isset($_REQUEST['submit1']) )
		{
			$warning1 = false;
			$table = $conn->query( "SELECT count(*) CNT FROM ".$db_users." WHERE name = '".$_REQUEST['name']."' AND sname = '".$_REQUEST['sname']."'" );
			$person = mysqli_fetch_array( $table );
			if ( $person['CNT'] == 0 ) $warning1 = true;
		}
		
		else if ( isset($_REQUEST['submit2']) )
		{
			$warning2 = false;
			$table = $conn->query( "SELECT count(*) CNT FROM ".$db_users." WHERE user = '".$_REQUEST['nick']."' AND domain = '".$_REQUEST['domain']."'" );
			$person = mysqli_fetch_array( $table );
			if ( $person['CNT'] != 1 ) $warning2 = true;
		}
		
		
		
		
		
		if ( !$warning1 ) //druhý průchod
		{
			?>
            <form method="get" id="formSignIn" >
            	<input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
                <input type="hidden" name="sname" value="<?php echo $_REQUEST['sname']; ?>" />
            	<table rules="none" id="tableSignIn">
                    <tr>
                    	<td>
                        	Nick
                        </td>
                    	<td>
                    		<input type="text" name="nick" value="<?php echo isset($_REQUEST['nick']) ? $_REQUEST['nick'] : ''; ?>" />
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        	Doména
                        </td>
                    	<td>
                        	<select name="domain">
                            	<?php
								$table = $conn->query( "SELECT * FROM ".$db_domains );
								while ( $row = mysqli_fetch_array( $table ) )
								{
									echo '<option value="'.$row['domain'].'"'.( isset($_REQUEST['domain']) && $_REQUEST['domain'] == $row['domain']? ' selected=""' : '').'>'.$row['domain'].'</option>';
								}
								?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        	<button name="submit2">Dále</button>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                        	<?php if ( isset($_REQUEST['submit2']) ) echo '<span class="red">Pod tímto e-mailem zde nejspíš nejste registrováni</span>'; ?>
                        </td>
                    </tr>
				</table>
            </form>
			<?php
		}
		else if ( !$warning2 )
		{
			?>
            
			<?php
		}
		else if ( !$warning3 )
		{
			?>
            
			<?php
		}
		else //první průchod
		{
			?>
            <form method="post" id="formSignIn" >
            	<table rules="none" id="tableSignIn">
                    <tr>
                    	<td>
                        	Vaše jméno
                        </td>
                    	<td>
                    		<input type="text" name="name" value="<?php echo isset($_REQUEST['name']) ? $_REQUEST['name'] : ''; ?>" />
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        	Vaše příjmení
                        </td>
                    	<td>
                    		<input type="text" name="sname" value="<?php echo isset($_REQUEST['sname']) ? $_REQUEST['sname'] : ''; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        	<button name="submit1">Dále</button>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                        	<?php if ( isset($_REQUEST['submit1']) ) echo '<span class="red">Pod tímto jménem zde nejspíš nejste registrováni</span>'; ?>
                        </td>
                    </tr>
				</table>
            </form>
			<?php
		}
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File promenne.php doesn't exists.</p>";
?>
</body>
</html>
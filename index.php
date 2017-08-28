<?php
$logged = false;
$admin = false;
$title = 'Útrata';
$promenne = '../promenne.php';
$name = '';
$passwd = '';
$HASH = md5( $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'] );

if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$person = '';
		
		if ( isset($_REQUEST['logOut']) ) {
			$spojeni->query( "UPDATE utrata_members SET logged=0, HASH=NULL WHERE HASH='".$HASH."'" );
		} else if ( isset($_REQUEST['jmeno']) && isset($_REQUEST['heslo']) )
		{
			$name = $_REQUEST['jmeno'];
			$passwd = $_REQUEST['heslo'];
			
			if ( isset($_REQUEST['login']) || isset($_REQUEST['sekce']) || isset($_REQUEST['back']) ) {
				$sql = $spojeni->query( "SELECT count(*) CNT FROM utrata_members WHERE login='".$_REQUEST['jmeno']."' AND passwd='".$_REQUEST['heslo']."'" );
				$sql = mysqli_fetch_array($sql);
				if ( $sql['CNT'] == 1 )
				{
					$sql = $spojeni->query( "SELECT M.*, C.value FROM utrata_members M LEFT JOIN utr_currencies C ON M.currencyID=C.CurrencyID WHERE login='".$_REQUEST['jmeno']."' AND passwd='".$_REQUEST['heslo']."'" );
					$person = mysqli_fetch_array( $sql );
					$logged = true;
					$title = $person['name'].'\'s útrata';
					$spojeni->query( "UPDATE utrata_members SET logged=1, HASH='".$HASH."', access='".date( 'Y-m-d H:i:s' )."' WHERE login = '".$_REQUEST['jmeno']."'" );
				}
			} else if ( isset($_REQUEST['admin']) ) {
				$sql = $spojeni->query( "SELECT M.*, C.value FROM utrata_members M LEFT JOIN utr_currencies C ON M.currencyID=C.CurrencyID WHERE login='".$_REQUEST['jmeno']."' AND passwd='".$_REQUEST['heslo']."'" );
				$administrator = mysqli_fetch_array( $sql );
				if ( $administrator['admin'] ) $admin = true;
			}
		} else {
			$sql = $spojeni->query( "SELECT M.*, C.value FROM utrata_members M LEFT JOIN utr_currencies C ON M.currencyId=C.CurrencyID WHERE HASH = '".$HASH."'" );
			while ( $person2 = mysqli_fetch_array( $sql ) ) {
				if ( $person2['logged'] == 1 )
				{
					$person = $person2;
					$logged = true;
					$title = $person['name'].'\'s útrata';
				
					$name = $person['login'];
					$passwd = $person['passwd'];
				}
			}
		}
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
        <meta name="description" content="Databáze útraty našich dětí" />
        <meta name="keywords" content="útrata, přehled" />
        <meta name="author" content="Vojtěch Stuchlík"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
        <script src="together/scripty/dbConn.js" type="text/javascript"></script>
        <?php if ( $admin) { ?>
			<script src="together/admin/fce.js" type="text/javascript"></script>
        	<link rel="stylesheet" type="text/css" href="together/admin/css.css">
		<?php } ?>
        <link rel="stylesheet" type="text/css" href="together/styly.css">
		<title><?php echo $title; ?></title>
		</head>
		<body id="body">
        
		<?php
		if ( !$logged && !$admin )
		{
			?>
			<form method="post" id="prihlasit">
				<table rules="none">
					<tr>
						<td>
							<label>Jméno: 
						</td>
						<td>
							<input <?php if ( isset($_REQUEST['jmeno']) && !$logged ) echo 'style="border:solid red 1px;"';?> name="jmeno" type="text" value="<?php if (isset($_REQUEST['jmeno'])) echo $_REQUEST['jmeno'];?>" id="focus" /></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Heslo: 
						</td>
						<td>
							<input <?php if ( isset($_REQUEST['heslo']) && !$logged ) echo 'style="border:solid red 1px;"';?> name="heslo" type="password" /></label>
						</td>
					</tr>
					<tr>
						<td>
							<button type="submit" name="login">Přihlásit</button>
						</td>
						<td>
							<span id="forgottenPasswd">Zapomenuté přihlašovací údaje</span>
						</td>
					</tr>
				</table>
                <button id="admin" name="admin">administrator</button>
			</form>
			
			<div id="modal">
				<div id="modalContent">
					<div id="header">
						<span id="close">&times;</span>
						<h2>Zapomenuté údaje</h2>
					</div>
					<div id="content">
						<table rules="none">
							<tr>
								<td>
									<label for="mail">Váš e-mail</label>
								</td>
								<td>
									<input type="text" id="mail" />
								</td>
							</tr>
							<tr>
								<td>
									<button onclick="sendForgottenData()">Odeslat</button>
								</td>
							</tr>
						</table>
					</div>
					<div id="footer">
						<strong id="footerP"></strong>
					</div>
				</div>
			</div>
			
			<script type="text/javascript">
				document.getElementById( 'focus' ).focus();
				/*----------------------------------------------------*/
				var modal = document.getElementById( 'modal' );
				var btn = document.getElementById( 'forgottenPasswd' );
				var clos = document.getElementById( 'close' );
				
				btn.onclick = function(){
					modal.style.display = 'block';
					document.getElementById( 'mail' ).focus();
				}
				clos.onclick = function() {
					modal.style.display = 'none';
					document.getElementById( 'focus' ).focus();
				}
				window.onclick = function(e) {
					if ( e.target == modal ) {
						//modal.style.display = 'none';
						//document.getElementById( 'focus' ).focus();
					}
				}
				window.onkeydown = function(e) {
					if ( e.keyCode == 27 ) { // press ESC
						modal.style.display = 'none';
						document.getElementById( 'focus' ).focus();
					}
				}
			</script>
		<?php 
		} 
		else if ( !$admin )
		{
			$name= $person['name'];
			$login = $person['login'];
			$passwd = $person['passwd'];
			$sendMonthly = $person['sendMonthly'];
			$sendByOne = $person['sendByOne'];
			$mother = $person['mother'];
			$me = $person['me'];
			$currency = $person['value'];
			
			$file = 'together/';
			if ( isset($_POST['sekce']) )
			{
				switch ( $_POST['sekce'] )
				{
					case 'pridat':
						$file .= 'pridat.php';
						break;
					case 'platba':
						$file .= 'platba.php';
						break;
					case 'stare_ucty':
						$file .= 'stare_ucty.php';
						break;
					case 'settings':
						$file .= 'settings.php';
						break;
					default:
						$file .= 'uvod.php';
						break;
				}
			}
			else $file .= 'uvod.php';
			
			
			
			if ( file_exists($file) ) {
				//echo '<script type="text/javascript">';
				//echo 'drawPage( "body", "'.$file.'" )';
				//echo '<script>';
				require($file);
			}
			else echo "<p>File $file doesn't exist.</p>";
		}
		else {
			require __DIR__."/together/admin.php";
		}
	}
	else echo "<p>Connection with database had failed.</p>";
}
else {
	echo "<p>File $promenne doesn't exist.</p>";
	echo '</head>';
	echo '<body id="body">';
}
?>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="styly/styles.css" media="all" />
    <link rel="stylesheet" type="text/css" href="styly/baseColor.css" media="all" />
    <link rel="stylesheet" type="text/css" href="styly/registration.css" media="all" />
<title>Resgistrace</title>
</head>
<body>
<?php if ( file_exists( "promenne.php" ) && require( "promenne.php" ) ) {?>
<?php 	if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) ) {
        
		$nameMinStrlen = 3;
		$snameMinStrlen = 3;
		$answerMinStrlen = 2;
		$nickMinStrlen = 4;
		
		$warningName = false;
		$warningSname = false;
		$warningNick1 = false;
		$warningNick2 = false;
		$warningPasswd = false;
		$warningPasswdAgain = false;
		$warningAnswer = false;
		$warning = false;
		if ( isset($_POST['submit']) )
		{
			if ( strlen(trim($_POST['name'])) < $nameMinStrlen ) $warningName = true;
			if ( strlen(trim($_POST['sname'])) < $snameMinStrlen ) $warningSname = true;
			
			if ( strlen(trim($_POST['nick'])) < $nickMinStrlen ) $warningNick1 = true;
			else
			{
				$table = $conn->query( "SELECT count(*) CNT FROM ".$db_users." WHERE user = '".$_POST['nick']."' AND domain = '".$_POST['domain']."'" );
				$person = mysqli_fetch_array( $table );
				if ( $person['CNT'] == 1 ) $warningNick2 = true;
			}
			if ( !preg_match( '/[0-9]/', $_POST['passwd'] ) || !preg_match( '/[a-zA-Z]/', $_POST['passwd'] ) ) $warningPasswd = true;
			if ( $_POST['passwd'] != $_POST['passwdAgain'] ) $warningPasswdAgain = true;
			if ( strlen(trim($_POST['controlAns'])) < $answerMinStrlen ) $warningAnswer = true; 
		}
		if ( $warningAnswer || $warningNick1 || $warningNick2 || $warningName || $warningSname || $warningPasswd || $warningPasswdAgain ) $warning = true;
		
		
		if ( !isset($_POST['submit']) || $warning )
		{
			?>
			
			<form id="formSignIn" method="post" >
				<a href="."><input type="button" value="Zpět" id="backButton" /></a>
				<table rules="none" id="tableSignIn">
					<tr><td>
						Jméno:
					</td><td>
						<input name="name" type="text" value="<?php if ( isset($_POST['name']) ) echo $_POST['name']; ?>" />
					</td><td>
						<?php if ( $warningName ) echo '<span class="red">Alespoň '.$nameMinStrlen.' znaků</sapn>'; ?>
					</td></tr>
					<tr><td>
						Příjmení:
					</td><td>
						<input name="sname" type="text" value="<?php if ( isset($_POST['sname']) ) echo $_POST['sname']; ?>" />
					</td><td>
						<?php if ( $warningSname ) echo '<span class="red">Alespoň '.$snameMinStrlen.' znaků</sapn>'; ?>
					</td></tr>
					<tr><td>
						Nick: <br /><em class="pozn">jméno před zavináčem</em>
					</td><td>
						<input name="nick" type="text" value="<?php if ( isset($_POST['nick']) ) echo $_POST['nick']; ?>" />
						@
						<select name="domain">
							<?php
								$table = $conn->query( "SELECT * FROM ".$db_domains );
								while ( $row = mysqli_fetch_array( $table ) )
								{
									echo '<option value="'.$row['domain'].'" >'.$row['domain'].'</option>';
								}
							?>
						</select>
					</td><td>
						<?php
							if ( $warningNick1 ) echo '<span class="red">Alespoň '.$nickMinStrlen.' znaků</span>'; 
							else if ( $warningNick2 ) echo '<span class="red">Takový uživatel již existuje</span>';
						?>
					</td></tr>
					<tr><td>
						Heslo:
					</td><td>
						<input name="passwd" type="password" value="" />
					</td><td>
						<?php if ( $warningPasswd ) echo '<span class="red">Alespoň jedno písmeno a číslo</span>'; ?>
					</td></tr>
					<tr><td>
						Heslo znova:
					</td><td>
						<input name="passwdAgain" type="password" value="" />
					</td><td>
						<?php if ( $warningPasswdAgain ) echo '<span class="red">Hesla se neshodují</span>'; ?>
					</td></tr>
					<tr><td>
						Kontrolní otázka:
					</td><td>
						<select name="controlQue">
							<?php
								$table = $conn->query( "SELECT * FROM ".$db_questions );
								$i = 0;
								while ( $row = mysqli_fetch_array( $table ) )
								{
									echo '<option value="'.$row['id'].'" '.( isset($_POST['controlQue']) && $_POST['controlQue'] == ++$i ? 'selected=""' : '').' >'.$row['question'].'</option>';
								}
							?>
						</select>
					</td></tr>
					<tr><td>
						Odpověď:
					</td><td>
						<input name="controlAns" type="text" value="" />
					</td><td>
						<?php if ( $warningAnswer ) echo '<span class="red">Alespoň '.$answerMinStrlen.' znaků</span>'; ?>
					</td></tr>
					<tr><td>
						<input type="submit" name="submit" value="Přihlásit" />
					</td><td colspan="2">
						<?php if ( $warning ) echo '<span class="red">Špatné údaje</span>';	?>
					</td></tr>
				</table>
			</form>
    	<?php 
		}
		else
		{
			$conn->query( "INSERT INTO ".$db_users." ( name, sname, controlQue, controlAns, user, passwd, domain, nick, eLastDate ) VALUES ( '".$_POST['name']."', '".$_POST['sname']."', ".$_POST['controlQue'].", '".$_POST['controlAns']."', '".$_POST['nick']."', '".$_POST['passwd']."', '".$_POST['domain']."', '".$_POST['name']." ".$_POST['sname']."', now() );" );
			echo '<div id="formSignIn"><p>Vše proběhlo vpořádku. Můžete se <a href=".">přihlásit</a></p></div>';
			$conn->query( "INSERT INTO ".$db_box." ( eFrom, eTo, eSubject, eText, eDate ) VALUES ( 'Krtekmail', '".$_POST['nick']."@".$_POST['domain']."', 'Vítejte', 'Vše ok?\nV nastavení si můžete změnit barevný vzhled stránky a podpis k e-mailu.\nPřeji příjemné posílání e-mailů.\nVojtěch Stuchlík - správce', now() );" );
		}
	}else echo '<p>Connection failed.</p>';
} else echo "<p>File promenne.php doesn't exists.</p>"; ?>

</body>
</html>
<?php
	if (stripos($_SERVER["HTTP_USER_AGENT"], "mobile") !== false) $onMobile= true;
	else $onMobile = false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0" />
    <title id="titleOfThePage">Krtekmail</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
    <script src="script/dbConn.js" type="text/javascript"></script>
    <script src="script/fce.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="styly/styles.css" media="all" />
    <link rel="stylesheet" type="text/css" href="styly/baseColor.css" media="all" />
    
    <?php
	$styleColor = 'pink';
	if ( isset($_POST['name']) && isset($_POST['passwd']) && isset($_POST['domain']) )
	{
		if ( file_exists( "promenne.php" ) && require( "promenne.php" ) )
		{
			if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
			{
				$row = mysqli_fetch_array( $conn->query( "SELECT count(*) CNT FROM ".$db_users." WHERE user = '".$_POST['name']."' AND domain = '".$_POST['domain']."' AND passwd = '".$_POST['passwd']."'" ) );
				if ( $row['CNT'] == 1 )
				{
					$row = mysqli_fetch_array( $conn->query( "SELECT * FROM ".$db_users." WHERE user = '".$_POST['name']."' AND domain = '".$_POST['domain']."' AND passwd = '".$_POST['passwd']."'" ) );
					$styleColor = $row['styleColor'];
				}
			}
		}
	}
	echo '<link rel="stylesheet" type="text/css" href="styly/'.$styleColor.'.css" media="all" />';
	?>
    
    
	<?php
	if ( $onMobile )
	{?>
		<link rel="stylesheet" type="text/css" href="styly/mStyles.css" media="all" />
        <script src="script/mobile.js" type="text/javascript"></script>
	<?php }
	
	if ( !file_exists( "promenne.php" ) || !require( "promenne.php" ) ) echo "<p>File promenne.php doesn't exists.</p>";
	else
	{ 
		function correct_user( $name, $passwd, $domain, $conn, $db_users )
		{
			//check how many users have same username
			$table = $conn->query( "SELECT count(*) CNT, user, passwd, domain FROM ".$db_users." WHERE user = '".$name."' AND domain = '".$domain."'" );
			$row = mysqli_fetch_array( $table );
			if ( $row['CNT'] != 1 ) return false;
			if ( $row['passwd'] == $passwd ) return true;
			return false;
		}
		
		$logged = false;
		if ( isset($_POST['name']) && isset($_POST['passwd']) && isset($_POST['domain']) )
		{
			$logged = true;
			if ( !($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) || !$conn->query( "SET CHARACTER SET UTF8" ) ) $logged = false;
			else if ( !correct_user( $_POST['name'], $_POST['passwd'], $_POST['domain'], $conn, $db_users ) ) $logged = false;
			else $conn->query( "UPDATE ".$db_users." SET eLastDate=now() WHERE user = '".$_POST['name']."' AND domain = '".$_POST['domain']."'" );
		}
	?>
</head>
<body <?php if ( $logged ) echo 'id="bodyLogged"'; ?>>
        <noscript><p>Pro správnou funkčnost této aplikace je nutné mít povolený JavaScript!</p></noscript>
        
        
    <?php
        if ( !$logged )
        {
            if ( !file_exists( "signin.php" ) || !require( "signin.php" ) ) echo "<p>File signin.php doesn't exists.</p>";
        }
        else
        {
            if ( !file_exists( "template.php" ) || !require( "template.php" ) ) echo "<p>File template.php doesn't exists.</p>";
        }
	}
	if ( $logged && $onMobile )
	{
    ?>
    	<script type="text/javascript">
		transformMenu();
        </script>
    <?php
	}
	?>
<script type="text/javascript">
document.getElementById( 'focus' ).focus();
</script>
</body>
</html>

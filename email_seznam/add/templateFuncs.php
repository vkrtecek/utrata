<?php
function substr_type( $type )
{
	switch ( $type )
	{
		case 'inBox':
			return 'Doručené';
			break;
		case 'outBox':
			return 'Odeslané';
			break;
		case 'binBox':
			return 'Koš';
			break;
		case 'spamBox':
			return 'SPAM';
			break;
		case 'nonReat':
			return 'Nepřečtené';
			break;
		case 'newMessage':
			return 'Napsat zprávu';
			break;
		case 'settings':
			return 'Nastavení';
			break;
	}

}

function getNick( $name, $domain )
{
	if ( file_exists( "promenne.php" ) && require( "promenne.php" ) )
	{
		if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
		{
			$table = $conn->query( "SELECT nick OK FROM ".$db_users." WHERE user = '".$name."' AND domain = '".$domain."'" );
			$row = mysqli_fetch_array( $table );
			return $row['OK'];
		}
		else return "unknown user";
	}
	else return "unknown user";
}

function unReatMessCNT( $name, $domain )
{
	if ( file_exists( "promenne.php" ) && require( "promenne.php" ) )
	{
		if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
		{
			$table = $conn->query( "SELECT count(*) CNT FROM ".$db_box." WHERE eTo = '".$name."@".$domain."' AND eReat = 0 AND eDel = 0 AND eSpam = 0" );
			$row = mysqli_fetch_array( $table );
			return $row['CNT'];
		}
		else return 0;
	}
	else return 0;
}













function myHeader( $type = 'inBox' )
{
	echo '<h1 class="welcome">Welcome '.getNick( $_POST['name'], $_POST['domain'] ).'</h1>';
	echo '<p class="welcome">'.substr_type( $type ).'</p>';
}

function myMenu()
{
	?>
    <script type="text/javascript">
		<?php  $inBoxNew = unReatMessCNT( $_POST['name'], $_POST['domain'] ); ?>
		document.getElementById( 'titleOfThePage' ).innerHTML = <?php echo '"'.(isset($_GET['type']) ? substr_type( $_GET['type'] ) : substr_type( 'inBox' ) ).'"';
		if ( $inBoxNew != 0 ) echo ' + " - (" + '.$inBoxNew.' + ")"'; ?>;
    </script>
	<ul>
    	<li>
        	<?php if ( !isset($_GET['type']) || $_GET['type'] != 'newMessage' ) {?>
                <form method="post" action="?type=newMessage">
                    <input name="name"   value="<?php echo $_POST['name']; ?>"   type="hidden" />
                    <input name="domain" value="<?php echo $_POST['domain']; ?>" type="hidden" />
                    <input name="passwd" value="<?php echo $_POST['passwd']; ?>" type="hidden" />
                    <input type="submit" value="Nová zpráva" class="inputActive" />
                </form>
            <?php } else {?>
            	<input type="submit" value="Nová zpráva" class="inputNoActive" />
            <?php }?>
        </li>
        <li>
        	<?php if ( !isset($_GET['type']) || $_GET['type'] != 'nonReat' ) {?>
                <form method="post" action="?type=nonReat">
                    <input name="name"   value="<?php echo $_POST['name']; ?>"   type="hidden" />
                    <input name="domain" value="<?php echo $_POST['domain']; ?>" type="hidden" />
                    <input name="passwd" value="<?php echo $_POST['passwd']; ?>" type="hidden" />
                    <input type="submit" value="Nepřečtené <?php echo '('.unReatMessCNT( $_POST['name'], $_POST['domain'] ).')';?>" class="inputActive" />
                </form>
            <?php } else {?>
            	<input type="submit" value="Nepřečtené <?php echo '('.unReatMessCNT( $_POST['name'], $_POST['domain'] ).')';?>" class="inputNoActive" />
            <?php }?>
        </li>
        <hr />
        <li>
        	<?php if ( isset($_GET['type']) && $_GET['type'] != 'inBox' ) {?>
                <form method="post" action="?type=inBox">
                    <input name="name"   value="<?php echo $_POST['name']; ?>"   type="hidden" />
                    <input name="domain" value="<?php echo $_POST['domain']; ?>" type="hidden" />
                    <input name="passwd" value="<?php echo $_POST['passwd']; ?>" type="hidden" />
                    <input type="submit" value="Doručené" class="inputActive" />
                </form>
            <?php } else {?>
            	<input type="submit" value="Doručené" class="inputNoActive" />
            <?php }?>
        </li>
        <li>
        	<?php if ( !isset($_GET['type']) || $_GET['type'] != 'outBox' ) {?>
                <form method="post" action="?type=outBox">
                    <input name="name"   value="<?php echo $_POST['name']; ?>"   type="hidden" />
                    <input name="domain" value="<?php echo $_POST['domain']; ?>" type="hidden" />
                    <input name="passwd" value="<?php echo $_POST['passwd']; ?>" type="hidden" />
                    <input type="submit" value="Odeslané" class="inputActive" />
                </form>
            <?php } else {?>
            	<input type="submit" value="Odeslané" class="inputNoActive" />
            <?php }?>
        </li>
        <li>
        	<?php if ( !isset($_GET['type']) || $_GET['type'] != 'spamBox' ) {?>
                <form method="post" action="?type=spamBox">
                    <input name="name"   value="<?php echo $_POST['name']; ?>"   type="hidden" />
                    <input name="domain" value="<?php echo $_POST['domain']; ?>" type="hidden" />
                    <input name="passwd" value="<?php echo $_POST['passwd']; ?>" type="hidden" />
                    <input type="submit" value="Spam" class="inputActive" />
                </form>
            <?php } else {?>
            	<input type="submit" value="Spam" class="inputNoActive" />
            <?php }?>
        </li>
        <li>
        	<?php if ( !isset($_GET['type']) || $_GET['type'] != 'binBox' ) {?>
                <form method="post" action="?type=binBox">
                    <input name="name"   value="<?php echo $_POST['name']; ?>"   type="hidden" />
                    <input name="domain" value="<?php echo $_POST['domain']; ?>" type="hidden" />
                    <input name="passwd" value="<?php echo $_POST['passwd']; ?>" type="hidden" />
                    <input type="submit" value="Koš" class="inputActive" />
                </form>
            <?php } else {?>
            	<input type="submit" value="Koš" class="inputNoActive" />
            <?php }?>
        </li>
        <hr />
        <li>
        	<?php if ( !isset($_GET['type']) || $_GET['type'] != 'settings' ) {?>
                <form method="post" action="?type=settings">
                    <input name="name"   value="<?php echo $_POST['name']; ?>"   type="hidden" />
                    <input name="domain" value="<?php echo $_POST['domain']; ?>" type="hidden" />
                    <input name="passwd" value="<?php echo $_POST['passwd']; ?>" type="hidden" />
                    <input type="submit" value="Nastavení" class="inputActive" />
                </form>
            <?php } else {?>
            	<input type="submit" value="Nastavení" class="inputNoActive" />
            <?php }?>
        </li>
        <li>
            <form method="post" action="">
                <input type="submit" value="Odhlásit" class="inputActive" />
            </form>
        </li>
    </ul>
    <?php
}

function myFooter()
{
}

?>
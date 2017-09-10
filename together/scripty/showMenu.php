<?php

$promenne = '../../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{?>
		<form method="post" action="">
				<input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
				<input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
				<input type="hidden" name="sekce" value="pridat" />
				<button type="submit" name="pridat" class="menu" id="addItem"><?=translateByCode($spojeni, 'login', $_REQUEST['j'], 'Menu.AddItem');?></button>
		</form>
		<form method="post" action="">
				<input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
				<input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
				<input type="hidden" name="sekce" value="platba" />
				<button type="submit" name="platba" class="menu" id="addTransaction"><?=translateByCode($spojeni, 'login', $_REQUEST['j'], 'Menu.AddMoney');?></button>
		</form>
		<form method="post" action="">
				<input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
				<input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
				<input type="hidden" name="sekce" value="stare_ucty" />
				<button type="submit" name="stare_ucty" class="menu" id="oldBills"><?=translateByCode($spojeni, 'login', $_REQUEST['j'], 'Menu.OldItems');?></button>
		</form>
		<form method="post" action="">
				<input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
				<input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
				<input type="hidden" name="sekce" value="settings" />
				<button type="submit" name="settings" class="menu" id="settings"><?=translateByCode($spojeni, 'login', $_REQUEST['j'], 'Menu.Settings');?></button>
		</form>
		<?php if ( $_REQUEST['sendMonthly'] )
		{
			echo '<button style="margin-top:5px;" onClick="motherToggle()">'.translateByCode($spojeni, 'login', $_REQUEST['j'], 'Menu.SendToMother').'</button><br />';
		}?>
		<button class="menu" onclick="downloadBackUp( '<?php echo $_REQUEST['name']; ?>' )" id="downloadBackUp"><?=translateByCode($spojeni, 'login', $_REQUEST['j'], 'Menu.DownloadBackUp');?></button>
		<form method="post" action="">
				<button name="logOut" type="submit" class="menu odhlasit" id="logout"><?=translateByCode($spojeni, 'login', $_REQUEST['j'], 'Menu.Logout');?></button>
		</form>
		<span id="helpSpan" title="<?=translateByCode($spojeni, 'login', $_REQUEST['j'], 'Menu.ShortcutsTitle');?>" style="cursor:help;"><?=translateByCode($spojeni, 'login', $_REQUEST['j'], 'Menu.Shortcuts');?></span>
		<div id="scrollUp"></div>
		<?php
	} else echo "<p>Connection with database had failed.</p>";
} else echo "<p>File $promenne doesn't exists.</p>";
<form method="post" action="">
    <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
    <input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
    <input type="hidden" name="sekce" value="pridat" />
    <button type="submit" name="pridat" class="menu" id="addItem">Přidat položku</button>
</form>
<form method="post" action="">
    <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
    <input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
    <input type="hidden" name="sekce" value="platba" />
    <button type="submit" name="platba" class="menu" id="addTransaction">Nová transakce</button>
</form>
<form method="post" action="">
    <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
    <input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
    <input type="hidden" name="sekce" value="stare_ucty" />
    <button type="submit" name="stare_ucty" class="menu" id="oldBills">Staré účty</button>
</form>
<form method="post" action="">
    <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
    <input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
    <input type="hidden" name="sekce" value="settings" />
    <button type="submit" name="settings" class="menu" id="settings">Nastavení</button>
</form>
<?php if ( $_REQUEST['sendMonthly'] )
{
	echo '<button style="margin-top:5px;" onClick="motherToggle()">Poslat mamce</button><br />';
}?>
<button class="menu" onclick="downloadBackUp( '<?php echo $_REQUEST['name']; ?>' )" id="downloadBackUp">Stáhnout zálohu</button>
<form method="post" action="">
    <button name="logOut" type="submit" class="menu odhlasit" id="logout">Odhlásit</button>
</form>
<span id="helpSpan" title="Ctrl+, - new Item 
Ctrl+M - new payment
Ctrl+O - old items
Ctrl+S - settings
Ctrl+Z - back in history
Ctrl+Y - next in history
Ctrl+B - bak to main page
Ctrl+L - logout" style="cursor:help;">Shortcuts</span>
<div id="scrollUp"></div>
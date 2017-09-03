<?php

function toDefaultTime( $in )
{
	$date = explode( ' ', $in );
	if ( count($date) == 1 ) return $in;
	$time = explode( ':', $date[1] );
	
	return $date[0].'T'.$time[0].':'.$time[1];
}

	
?>
<h1>Přidat položku do databáze</h1>
<div id="right">
    <form method="post" action="">
        <input name="jmeno" value="<?php echo $login;?>" type="hidden" />
        <input name="heslo" value="<?php echo $passwd;?>" type="hidden" />
        <input type="hidden" name="sekce" value="uvod" />
        <button type="submit" name="back" class="menu">Zpět na inventář</button>
    </form>
</div>
	
<div id="add_form">
<?php 

    require( 'getMyTime().php' );
    ?>
        <p><label> Název:<strong class="red">*</strong> <input class="ins" name="nahr_nazev" id="nahr_name" value="<?php if (isset($_REQUEST['nahr_nazev'])) echo $_REQUEST['nahr_nazev'];?>" /></label></p><br />
        <p id="napoveda">
					<input type="checkbox" id="nahr_odepsat" onchange="document.getElementById('nahr_vyber').checked=false;" /><label for="nahr_odepsat"> Odepsat</label>
          <input type="checkbox" id="nahr_vyber" onchange="document.getElementById('nahr_odepsat').checked=false;" /><label for="nahr_vyber"> Výběr</label>
        <p><label>Popis: <textarea class="ins" name="nahr_popis" id="nahr_desc" rows="1"><?php if (isset($_REQUEST['nahr_popis'])) echo $_REQUEST['nahr_popis'];?></textarea></label></p><br />
				<p>Poznámka: 
					<select name="nahr_pozn" id="nahr_pozn" size="1">
						<span id="purposesHere"></span>
					</select>
				</p><br />
        <p>Typ platby: <select name="nahr_typ" id="nahr_type" rows="1">
            <option value="karta" <?php if (isset($_REQUEST['nahr_typ']) && $_REQUEST['nahr_typ'] == 'karta') echo 'selected="selected"';?>>Karta</option>
            <option value="hotovost" <?php if (isset($_REQUEST['nahr_typ']) && $_REQUEST['nahr_typ'] == 'hotovost') echo 'selected="selected"';?>>Hotovost</option>
        </select></p><br />
        <p>Datum: <input type="datetime-local" name="datum" id="nahr_date" value="<?php echo toDefaultTime( getMyTime() ); ?>" />
        </p><br />
        <p>
        	<label> Cena:<strong class="red">*</strong> <input type="number" step="0.01" id="cena" name="nahr_cena" value="<?php if (isset($_REQUEST['nahr_cena'])) echo $_REQUEST['nahr_cena'];?>" /> <?php echo $currency; ?></label>
        	<div id="otherCurrencyDiv"><input id="otherCurrency" type="checkbox" onchange="otherCurrency( 'otherCurrencySpan', '<?= $currency; ?>' )" /><label for="otherCurrency" > Jiná měna</label><span id="otherCurrencySpan"></span></div>
        </p><br />
        <input name="jmeno" value="<?php echo $login; ?>" type="hidden" />
        <input name="heslo" value="<?php echo $passwd; ?>" type="hidden" />
        <input type="hidden" name="sekce" value="pridat" />
        <button typename="nahrat" name="nahrat" onclick="nahratItem( 'add_form', '<?=$login;?>', '<?=$passwd;?>', '<?=$name;?>' )">Nahrát</button> <em class="red">*Povinné pole</em></p><br />
    
    <?php
    echo ' <strong class="red" id="fillName"></strong><br />';
    echo ' <strong class="red" id="fillPrice"></strong><br />';
	echo '</div>';
?>
<script type="text/javascript">
printPurposes( 'purposesHere', '<?=$login;?>' );
</script>
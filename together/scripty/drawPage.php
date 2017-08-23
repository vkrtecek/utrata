<?php
if (!file_exists('../../../promenne.php'))
{
		echo '<div class="oznameni"><h3><strong>Omlouvám se, ale databáze není k&nbsp;dispozici. Kontaktujte prosím správce ( <a href="mailto:krtek@zlin6.cz?subject=Vypadek%20databaze%20utrata">krtek@zlin6.cz</a> ).</strong></h3></div>';
}
else
{
	require('../../../promenne.php');
?>
</style>
</head>
<body id="body">        
<?php
	$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
	if (!$spojeni)
	{
		echo '<div class="oznameni"><h3><strong>Spojení s databází selhalo</strong></h3></div>';
	}
	else
	{
		if ( isset($_REQUEST['check_K']) && file_exists( "getMyTime().php" ) )
		{
			require("getMyTime().php");
			$spojeni->query("SET CHARACTER SET UTF8");
			$spojeni->query( "UPDATE utrata_check_state SET checked = '".getMyTime()."' WHERE id = 1" );
		}
		if ( isset($_REQUEST['check_H']) && file_exists( "getMyTime().php" ) )
		{
			require( "getMyTime().php" );
			$spojeni->query("SET CHARACTER SET UTF8");
			$spojeni->query( "UPDATE utrata_check_state SET checked = '".getMyTime()."' WHERE id = 2" );
		}
		if (isset($_REQUEST['smazat_prispevek'])) $spojeni->query("UPDATE utrata_vojta SET platnost = 0 WHERE ID = '".$_REQUEST['smazat_prispevek']."'");
		
		if ( isset( $_REQUEST['jmeno'] ) && strtolower( $_REQUEST['jmeno'] ) == $vychozi_jmeno && $_REQUEST['heslo'] == $vychozi_heslo )
		{			
		?>
			<div id="right">
            <form method="post" action="pridat.php">
                <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['jmeno'];?>" />
                <input type="hidden" name="heslo" value="<?php echo $_REQUEST['heslo'];?>" />
                <button type="submit" name="pridat" class="menu">Přidat položku</button>
            </form>
            <form method="post" action="platba.php">
                <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['jmeno'];?>" />
                <input type="hidden" name="heslo" value="<?php echo $_REQUEST['heslo'];?>" />
                <button type="submit" name="platba" class="menu">Nová transakce</button>
            </form>
            <form method="post" action="stare_ucty.php">
                <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['jmeno'];?>" />
                <input type="hidden" name="heslo" value="<?php echo $_REQUEST['heslo'];?>" />
                <button type="submit" name="stare_ucty" class="menu">Staré účty</button>
            </form>
            <form method="post" action="">
                <button type="submit" class="menu odhlasit">Odhlásit</button>
            </form>
            </div>
            <h1>Vojtova útrata :-)</h1>
            
            <div id="items">
            <div class="right">
            <form method="post" >
                <input type="text" name="hledane_slovo"/>
                <input name="jmeno" value="<?php echo $_REQUEST['jmeno'];?>" type="hidden" />
				<input name="heslo" value="<?php echo $_REQUEST['heslo'];?>" type="hidden" />
                <button type="submit" name="hledat">Vyhledat</button>
            </form>
            </div>
        
          <form method="post"><p>Řadit podle: 
              <select name="razeni" size="1">
                  <option value="nazev" <?php if (isset($_REQUEST['razeni']) && $_REQUEST['razeni'] == 'nazev') echo 'selected="selected"';?>>Název</option>
                  <option value="ID" <?php if (isset($_REQUEST['razeni']) && $_REQUEST['razeni'] == 'ID') echo 'selected="selected"';?>>Datum</option>
                  <option value="cena" <?php if (isset($_REQUEST['razeni']) && $_REQUEST['razeni'] == 'cena') echo 'selected="selected"';?>>Cena</option>
              </select>
              <select name="razeni_styl" size="1">
                  <option value="ASC" <?php if (isset($_REQUEST['razeni_styl']) && $_REQUEST['razeni_styl'] == 'ASC') echo 'selected="selected"';?>>Vzestupně</option>
                  <option value="DESC" <?php if (isset($_REQUEST['razeni_styl']) && $_REQUEST['razeni_styl'] == 'DESC') echo 'selected="selected"';?>>Sestupně</option>
              </select>
              <input name="jmeno" value="<?php echo $_REQUEST['jmeno'];?>" type="hidden" />
              <input name="heslo" value="<?php echo $_REQUEST['heslo'];?>" type="hidden" />
              a vybrat pouze: 
              <input name="jmeno" value="<?php echo $_REQUEST['jmeno'];?>" type="hidden" />
              <input name="heslo" value="<?php echo $_REQUEST['heslo'];?>" type="hidden" />
              <select name="mesic" size="1">
              	<option value="" >- Měsíc -</option>
              	<?php
				$mes_nazev = array('Leden','Únor','Březen','Duben','Květen','Červen','Červenec','Srpen','Září','Říjen','Listopad','Prosinec');
				for ($i = 0; $i < count($mes_nazev); $i++)
				{
					echo '<option value="'.$mes_nazev[$i].'" ';
					if (isset($_REQUEST['mesic']) && $_REQUEST['mesic'] == $mes_nazev[$i]) echo 'selected="selected"';
					echo '>'.$mes_nazev[$i].'</option>';
				}
				?>
              </select>
               nebo
               <select name="najdi_pozn" size="1">
               <option value="" <?php if (isset($_REQUEST['najdi_pozn']) && $_REQUEST['najdi_pozn'] == 'jidlo') echo 'selected="selected"';?>>- Poznámka -</option>
               		<option value="jidlo" <?php if (isset($_REQUEST['najdi_pozn']) && $_REQUEST['najdi_pozn'] == 'jidlo') echo 'selected="selected"';?>>Jídlo</option>
                    <option value="ostatni" <?php if (isset($_REQUEST['najdi_pozn']) && $_REQUEST['najdi_pozn'] == 'ostatni') echo 'selected="selected"';?>>Ostatní</option>
               </select>
              <label>rok: <input style="width:40px" type="text" name="rok" value="<?php if (isset($_REQUEST['rok'])) echo $_REQUEST['rok'];?>"/></label>
              <button name="vyber">Vybrat</button></p>
          </form><br /><hr /><br />
          
          
          
          
          
          
          <?php
			$prikaz = 'SELECT * FROM utrata_vojta WHERE platnost = 1 AND nazev NOT LIKE "vyber" AND popis NOT LIKE "vyber"';
			if (!isset($_REQUEST['vyber']))
			{
				if ( !isset($_REQUEST['hledat']) ) $prikaz .= ' ORDER BY ID DESC';
			}
			else
			{
				if ($_REQUEST['najdi_pozn'] != '') $prikaz .= ' AND pozn = "'.$_REQUEST['najdi_pozn'].'"';
				$prikaz .= ' AND datum LIKE "%'.$_REQUEST['mesic'].'%" AND datum LIKE "%'.$_REQUEST['rok'].'%" ORDER BY '.$_REQUEST['razeni'].' '.$_REQUEST['razeni_styl'];
			}
			if (isset($_REQUEST['hledat'])) $prikaz .= ' AND nazev LIKE "%'.$_REQUEST['hledane_slovo'].'%" OR popis LIKE "%'.$_REQUEST['hledane_slovo'].'%" OR pozn LIKE "%'.$_REQUEST['hledane_slovo'].'%" ORDER BY nazev, popis ASC';
			//echo $prikaz;
			
			//echo "showTable( '".$prikaz."', 'hereTable', 'utrata_vojta' );";
			echo '<div id="hereTable"></div>';
			echo "<script>showItems( '".$prikaz."', 'hereTable', 'utrata_vojta' );</script>";
			
			
			
			
			$suma_celk_karta = 0;
			$suma_celk_hot = 0;
			$prikaz_karta = 'SELECT * FROM utrata_vojta WHERE typ = "karta"';
			$prikaz_hot = 'SELECT * FROM utrata_vojta WHERE typ = "hotovost"';
			$sql_karta = $spojeni->query($prikaz_karta);
			
			while ($cena = mysqli_fetch_array($sql_karta))
			{
				$suma_celk_karta += $cena['cena'];
			}

			$sql_hot = $spojeni->query($prikaz_hot);
			while ($cena = mysqli_fetch_array($sql_hot))
			{
				$suma_celk_hot += $cena['cena'];
			}
			$zustatek_karta = 0;
			$zustatek_hot = 0;
			$prikaz = 'SELECT * FROM utrata_akt_hodnota';
			$spojeni->query("SET CHARACTER SET UTF8");
			$sql = $spojeni->query($prikaz);
			while($ceny = mysqli_fetch_array($sql) )
			{
				if ( $ceny['typ'] == "karta" ) $zustatek_karta += $ceny['hodnota'];
				else $zustatek_hot += $ceny['hodnota'];
			}
			
			$zustatek_karta -= $suma_celk_karta;
			$zustatek_hot -= $suma_celk_hot;
			if ($zustatek_karta < 0) $redK = "red";
			else if ( $zustatek_karta == 0 ) $redK = "violet";
			else $redK = "";
			
			if ($zustatek_hot < 0) $redH = "red";
			else if ( $zustatek_hot == 0 ) $redH = "violet";
			else $redH = "";
			
			$sql = $spojeni->query("SELECT checked FROM utrata_check_state WHERE id = 1");
			$toto1 = mysqli_fetch_array( $sql );
			$sql = $spojeni->query("SELECT checked FROM utrata_check_state WHERE id = 2");
			$toto2 = mysqli_fetch_array( $sql );
			
			echo '<div id="prostred"><em>Zůstatek na kartě: 
					  <form method="post" class="check">
						<input name="jmeno" value="'.$_REQUEST['jmeno'].'" type="hidden" />
						<input name="heslo" value="'.$_REQUEST['heslo'].'" type="hidden" />
						<button name="check_K" class="'.$redK.'"><strong class="check_H">'.number_format((float)$zustatek_karta, 2, ',', ' ').' '.$currency.'</strong></button>
					  </form>
				  </em>'.$toto1['checked'].'<br />';
			echo '<em>Zůstatek hotovosti: 
					  <form method="post" class="check">
						<input name="jmeno" value="'.$_REQUEST['jmeno'].'" type="hidden" />
						<input name="heslo" value="'.$_REQUEST['heslo'].'" type="hidden" />
						<button name="check_H" class="'.$redH.'"><strong class="check_H">'.number_format((float)$zustatek_hot, 2, ',', ' ').' '.$currency.'</strong></button>
					  </form>
				  </em>'.$toto2['checked'].'
			      </div>';
			
			echo '</div>';
		}
		else
		{?>
        <div id="over_prihlasit">
        <a href="../"><button id="pri_but"> × </button></a>
        <form method="post" id="prihlasit">
            <table rules="none">
                <tr><td><label>Jméno: </td><td><input <?php if (isset($_REQUEST['jmeno']) && strtolower( $_REQUEST['jmeno'] ) != $vychozi_jmeno) echo 'style="border:solid red 1px;"';?> name="jmeno" type="text" value="<?php if (isset($_REQUEST['jmeno'])) echo $_REQUEST['jmeno'];?>" /></label></td></tr>
                <tr><td><label>Heslo: </td><td><input <?php if (isset($_REQUEST['heslo']) && strtolower( $_REQUEST['heslo'] ) != $vychozi_heslo) echo 'style="border:solid red 1px;"';?> name="heslo" type="password" /></label></td></tr>
                <tr><td><button type="submit" name="prihlasit">Přihlásit</button></td></tr>
            </table>
        </form>
        </div>
        <?php
		}
	}
}?>
<?php
function printSortingForm( $old, $name ) {
	?>
    <p>Řadit podle: 
    <select name="razeni" size="1" class="changeSort">
      <option value="nazev">Název</option>
      <option value="datum" selected="">Datum</option>
      <option value="cena">Cena</option>
    </select>
    <select name="razeni_styl" size="1"class="changeSort">
      <option value="ASC">Vzestupně</option>
      <option value="DESC" selected="">Sestupně</option>
    </select>
    a vybrat pouze: 
    <select name="mesic" size="1" class="changeSort">
    <option value="" >- Měsíc -</option>
    <?php
    $mes_nazev = array('Leden','Únor','Březen','Duben','Květen','Červen','Červenec','Srpen','Září','Říjen','Listopad','Prosinec');
    for ($i = 0; $i < count($mes_nazev); $i++)
        echo '<option value="'.str_pad( $i+1, 2, '0', STR_PAD_LEFT ).'" >'.$mes_nazev[$i].'</option>';
    ?>
    </select>
    nebo
    <select name="najdi_pozn" size="1" class="changeSort">
        <option value="">- Poznámka -</option>
        <option value="jidlo">Jídlo</option>
        <option value="transport">Transport</option>
        <option value="kosmetika">Kosmetika</option>
        <option value="leky">Léky</option>
        <option value="ostatni">Ostatní</option>
    </select>
    <label>rok: <input style="width:40px" type="text" name="rok" value="" class="changeSortBtn" /></label>
    
    <label> slovo: <input type="text" name="hledane_slovo" class="changeSortBtn" /> <span title="jednotlivé řetězce oddělujte dvěma mezerama &#010;pro napsání dvou mezer napiště '\ \ ' &#010;'!' před řetězcem - řetězec, který se v položce nikde nevyskytuje &#010;pro napsání vykřičníku použijte výraz '\!'">?</span></label>
    <span id="clear" title="výchozí filtrování" onclick="clearSearch( <?php echo "'".$name."', ".($old ? '0' : '1');?> )">×</span></p>
    <br /><hr /><br />
<?php } ?>
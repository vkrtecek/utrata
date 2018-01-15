<?php
function printSortingForm( $old, $name, $login, &$spojeni ) {
	?>
    <p><?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.OrderBy');?>: 
    <select name="razeni" size="1" class="changeSort">
      <option value="nazev"><?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.OrderBy.ItemName');?></option>
      <option value="datum" selected=""><?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.OrderBy.ItemDate');?></option>
      <option value="cena"><?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.OrderBy.ItemPrice');?></option>
    </select>
    <select name="razeni_styl" size="1"class="changeSort">
      <option value="ASC"><?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.OrderBy.Asc');?></option>
      <option value="DESC" selected=""><?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.OrderBy.Desc');?></option>
    </select>
    <?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.AndMonth');?>: 
    <select name="mesic" size="1" class="changeSort">
    <option value="" ><?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.Month.Default');?></option>
    <?php
    $mesice = array(
			translateByCode($spojeni, 'login', $login, 'Month.January'),
			translateByCode($spojeni, 'login', $login, 'Month.February'),
			translateByCode($spojeni, 'login', $login, 'Month.March'),
			translateByCode($spojeni, 'login', $login, 'Month.April'),
			translateByCode($spojeni, 'login', $login, 'Month.May'),
			translateByCode($spojeni, 'login', $login, 'Month.June'),
			translateByCode($spojeni, 'login', $login, 'Month.July'),
			translateByCode($spojeni, 'login', $login, 'Month.August'),
			translateByCode($spojeni, 'login', $login, 'Month.September'),
			translateByCode($spojeni, 'login', $login, 'Month.October'),
			translateByCode($spojeni, 'login', $login, 'Month.November'),
			translateByCode($spojeni, 'login', $login, 'Month.December')
		);
    for ($i = 0; $i < count($mesice); $i++)
        echo '<option value="'.str_pad( $i+1, 2, '0', STR_PAD_LEFT ).'" >'.$mesice[$i].'</option>';
    ?>
    </select>
    <?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.Or');?>
		<select name="najdi_pozn" size="1" class="changeSort" id="nahr_pozn" multiple>
			<!-- the function '' in scripty/dbConn.js->printPurposes fills options -->
    </select>
		<label><?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.Year');?>: <input style="width:40px" type="text" name="rok" value="" class="changeSortBtn" /></label>
    
    <label> <?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.Pattern');?>: <input type="text" name="hledane_slovo" class="changeSortBtn" /> <span title="<?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.HelpTitle');?>">?</span></label>
    <span id="clear" title="<?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.SetDefaultTitle');?>" onclick="clearSearch( <?php echo "'".$name."', ".($old ? '0' : '1');?> )">×</span></p>
    <br /><hr /><br />
		<script type="text/javascript">
			$(document).ready(function(){
				printPurposes( 'purposesHere', '<?=$login;?>', '<option value="" selected><?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.Types.Default');?></option>>' );
			});
			
			$('#nahr_pozn').click(function(){
				$(this).height('3em');
			});
		</script>
<?php } ?>
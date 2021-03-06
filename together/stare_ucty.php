<h1><?=translateByCode($spojeni, 'login', $login, 'OldItems.Heading1');?></h1>
<div id="right">
    <form method="post" action="index.php">
        <input name="jmeno" value="<?php echo $login;?>" type="hidden" />
        <input name="heslo" value="<?php echo $passwd;?>" type="hidden" />
        <button type="submit" name="back" class="menu" id="back" title="<?=translateByCode($spojeni, 'login', $login, 'Menu.Back')?>"><img width="40" height="40" src="together/img/back.jpg" alt="<?=translateByCode($spojeni, 'login', $login, 'Menu.Back');?>" /></button>
    </form>
    <div id="scrollUp"></div>
</div>


<div id="items">
    <?php
  	$sortForm = 'together/sortForm.php';
  	if ( file_exists($sortForm) && require($sortForm) ){
		printSortingForm( true, $name, $login, $spojeni );
	}
	else echo "<p>File $sortForm doesn't exists</p>";
  ?>
      
      
    <div id="hereTable"><img src="together/img/loading.gif" alt="načítání" /></div>
    <script>
				TWO_SPACES_BEGGINING = '<?=translateByCode($spojeni, 'login', $login, 'PrintItems.Filtering.Error.TwoSpaces');?>';
        LIMIT = 3000;
        showItems( 'hereTable', '<?php echo $name; ?>', LIMIT, 0 );
        
        $( ".changeSort" ).change(function(){
            showItems( 'hereTable', '<?php echo $name; ?>', LIMIT, 0 );
        });
        $( ".changeSortBtn" ).keyup(function(){
            showItems( 'hereTable', '<?php echo $name; ?>', LIMIT, 0 );
        });
        
        window.onscroll = function(){
            var tolerance = 0;
            var windowHeight = $(window).height();
            var maxHeight = $("body").innerHeight();
            var actualHeight = $("body").scrollTop();
            
            if ( actualHeight + tolerance + windowHeight >= maxHeight )
            {
                LIMIT += 300;
                showItems( 'hereTable', '<?php echo $name; ?>', LIMIT, 0 );
            }
			
			var actualScroll = $("body").scrollTop();
			if ( actualScroll > 0 ) document.getElementById( 'scrollUp' ).innerHTML = '<img onClick="scrollUp()" src="together/img/scrollUp.png" alt="scroll up" id="scrollUpImg" />';
			else document.getElementById( 'scrollUp' ).innerHTML = '';
        };
		function scrollUp()
		{
			$("body").scrollTop( '0' );
		}
    </script>
</div>
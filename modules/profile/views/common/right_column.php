<div data-uibox="right_column">

	<? if(
			($profile["education"] != "")
			|| ($profile["jobs"] != "")
			|| ($profile["social_activity"] != "")
			|| ($profile["political_activity"] != "")
	) {?>
		<? include 'right_column/personal_info.php'; ?>
	<?}?>
	
	<? if(count($common->peopleInMyCity) > 0){ ?>
		<? include 'right_column/in_my_city.php'; ?>
	<? } ?>
	
	<? include 'right_column/friends.php'; ?>

</div>
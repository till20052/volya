<? if( ! $structure["in_structure"]){ ?>
	<a data-action="join" data-id="<?=$structure["id"]?>" style="width: 270px; text-align: center" href="javascript:void(0);" class="v-button v-button-blue">
		<i class="icon icon-enter vamiddle"></i> <?=t("Долучитись до осередку")?>
	</a>
<? } ?>

<div data-id="info">

	<? include "sidebar/info.php" ?>

</div>

<div data-id="leadership">

	<? include "sidebar/leadership.php" ?>

</div>
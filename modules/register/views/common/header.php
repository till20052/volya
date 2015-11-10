<div class="header">
	<div class="breadcrumbs">

		<div>

			<? $__counter = 0 ?>

			<? foreach($application->breadcrumbs as $__breadcrumb){ ?>

				<? if(count($application->breadcrumbs) - 1 != $__counter){ ?>

					<a href="<?=$__breadcrumb["href"]?>"><h1 class="fleft"><?=$__breadcrumb["text"]?></h1></a> <h1 class="fleft">&nbsp;/&nbsp;</h1>

				<? } else { ?>

					<h1><?=$__breadcrumb["text"]?></h1>

				<? } ?>

				<? $__counter++ ?>

			<? } ?>

		</div>

	</div>
</div>
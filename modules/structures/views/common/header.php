<div class="headerNew">

	<div>
		<ul class="breadcrumb">

			<? $__counter = 0; ?>
			<? foreach($application->breadcrumbs as $__breadcrumb){ ?>

				<? if(count($application->breadcrumbs) - 1 != $__counter){ ?>

					<li><a href="<?=$__breadcrumb["href"]?>"><?=$__breadcrumb["text"]?></a></li>

				<? } else { ?>

					<li class="current"><?=$__breadcrumb["text"]?></li>

				<? } ?>

				<? $__counter++ ?>

			<? } ?>
		</ul>
	</div>

</div>
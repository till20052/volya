<? $categories = $structure["documents"]["categories"]; unset($structure["documents"]["categories"]) ?>

<? foreach ($categories as $category) { ?>

	<div class="categoty_title">
		<h3><?=$category["title"]?></h3>
	</div>

	<? foreach ($structure["documents"] as $document) { ?>

		<div data-ui="document" data-type="galery" data-src="/s/storage/<?=$document["hash"]?>">
			<i class="icon icon-document"></i>
			<?=$document["title"]?>
		</div>

	<? } ?>
<? } ?>

<div class="cboth"></div>
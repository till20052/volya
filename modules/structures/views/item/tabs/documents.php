<div ng-controller="UploadDocument" class="md-padding" id="popupContainer" ng-cloak>
	<div class="dialog-demo-content" layout="row" layout-wrap layout-margin layout-align="center">
		<md-button class="md-primary md-raised" ng-click="showFileUploader($event)">
			Завантажити документ
		</md-button>
	</div>
</div>


<? $categories = $structure["documents"]["categories"]; unset($structure["documents"]["categories"]) ?>

<? foreach ($categories as $category) { ?>

	<? if(count($structure["documents"]) > 0){ ?>
		<div class="categoty_title">
			<h3><?=$category["title"]?></h3>
		</div>

		<? foreach ($structure["documents"] as $document) { ?>

			<div data-ui="document" data-type="galery" data-src="/s/storage/<?=$document["hash"]?>">
				<i class="icon icon-document"></i>
				<?=$document["title"]?>
			</div>

		<? } ?>
	<? } else{ ?>
		<h3><?=t("Ще немає жодного рішення")?></h3>
	<? } ?>
<? } ?>

<div class="cboth"></div>
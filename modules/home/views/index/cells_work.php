<div data-uiBox="cells_work">
	<div>

		<div>

			<a href="/news?category=by_regions">
				<h2><?=t("Робота осередків")?></h2>
			</a>
		</div>

		<div class="mt30">

			<div data-uiTable="news">
				<? $__rowsCount = $__colsCount = 3 ?>
				<? $__rowsCounter = $__colsCounter = 0 ?>
				<? foreach($cellsWork["news"] as $__item){ ?>

					<? if($__rowsCounter == 0){ ?>
						<div>
					<? } ?>

					<div>

						<? $__geo = OldGeoClass::i()->getCity($__item["geo_koatuu_code"]) ?>

						<div style="color: #999"><?=$application->intlDateFormatter->format(strtotime($__item["created_at"]))?></div>

						<div class="mt5">
							<a href="/news?category=by_regions&geo=<?=$__geo["id"]?>" class="icon">
								<i class="icon-map-marker"></i>
								<span><?=$__geo["title"]?><?=(isset($__geo["region"]) ? ", ".$__geo["region"] : "")?></span>
							</a>
						</div>

						<div class="mt5">
							<a href="/news/<?=$__item["id"]?>"><?=$__item["title"][Router::getLang()]?></a>
						</div>

					</div>

					<? if($__rowsCounter == $__rowsCount - 1) { ?>
						</div>
						<? if($__colsCounter < $__colsCount - 1){ ?>
							<div>
								<div></div>
							</div>
						<? } ?>
						<? $__rowsCounter = 0 ?>
						<? $__colsCounter++ ?>
					<? } else { ?>
						<? $__rowsCounter++ ?>
					<? } ?>

				<? } ?>
			</div>

		</div>

	</div>
</div>
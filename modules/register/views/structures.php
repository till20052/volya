<? include "common/header.php"; ?>

<div class="section">

	<div>
		<div><? var_dump($cred) ?></div>

		<div data-uiBox="toolbar">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>
					<td>
						<a data-action="create" href="javascript:void(0);" class="v-button v-button-blue"><i class="icon icon-branch"></i> <?=t("Створити")?></a>
					</td>
				</tr>
				<tr class="dnone">
					<? if( ! (count($registerUser["geo_koatuu_code"]) > 0)){ ?>
						<td>
							<div class="mt15"><?=t("Область")?></div>
							<div class="mt5" style="width: 250px">
								<select data-ui="region" data-value="<?=isset($filter["region"]) ? $filter["region"] : 0 ?>" style="width: 250px">
									<option value="0">&mdash;</option>
									<? foreach(GeoClass::i()->regions() as $region){ ?>
										<option value="<?=$region["id"]?>"><?=$region["title"]?></option>
									<? } ?>
								</select>
							</div>
						</td>
					<? } ?>

					<?
						if(isset($filter["region"]))
							$citiesWithDistricts = GeoClass::i()->citiesWithDistricts($filter["region"]);
					?>

					<? if( isset($filter["region"]) && ! isset($filter["city"]) ){ ?>
						<td class="pl15">
							<div class="mt15"><?=t("Місто")?> / <?=t("Район")?></div>
							<div class="mt5">
								<select data-ui="area" data-value="<?=isset($filter["area"]) ? $filter["area"] : 0 ?>">
									<option value="0">&mdash;</option>
									<? foreach($citiesWithDistricts as $cities){ ?>
										<? if( $cities["type"] == "city"){ ?>
											<option data-type="city" value="<?=$cities["id"]?>"><?=$cities["title"]?></option>
										<? } ?>
									<? } ?>
									<? foreach($citiesWithDistricts as $district){ ?>
										<? if( $district["type"] == "district"){ ?>
											<option data-type="district" value="<?=$district["id"]?>"><?=$district["title"]?></option>
										<? } ?>
									<? } ?>
								</select>
							</div>
						</td>
					<? } ?>

					<td width="99%">
						<? if( count($filter) > 0){ ?>
							<div class="mt5 pl15 pt15">
								<a href="/register/members" style="text-decoration: none">
									<i class="icon icon-remove vamiddle" style="vertical-align: text-bottom;"></i> <?=t("Відмінити фільтрування")?>
								</a>
							</div>
						<? } ?>
					</td>

				</tr>
				</tbody>
			</table>
		</div>

		<div class="mt15">
			<table data-ui="list">
				<script id="data">(<?=json_encode([
			"columns" => array(
				["title" => "ID", "width" => "5%"],
				["title" => "", "width" => "13%"],
				["title" => t("Інформація")],
				["title" => t("Членів"), "width" => "7%"],
				["title" => t("Дії"), "width" => "12%"],
			),
			"dataSource" => [
				"data" => $list,
				"scheme" => [
					"model" => ["id" => "id"]
				]
			]
		])?>);</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">#=id#</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="tacenter fs12">
						# if(verification != null && verification.type < 0) { #
							<span style="color: red"><?=t("Дані не коректні")?></span>
						# } else if(verification != null && verification.type > 0){ #
							<span style="color: green"><?=t("Дані коректні")?></span>
						# } else { #
							<span style="color: \#f18303"><?=t("Дані не перевірені")?></span>
						# } #
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5">
						<div>
							<a href="/structure/#=id#" target="_blank">#=title#</a>
						</div>
						# if(typeof locality == "string"){ #
						<div>#=locality#</div>
						# } #
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5 tacenter">
						#=mcount#
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5 tacenter">
						<div class="fs12">
							# if(verification == null || verification.type <= 0) { #
								<a data-action="view" data-id="#=id#" href="javascript:void(0);" class="icon">
									<span style="color: \#f18303"><?=t("Перевірити")?></span>
								</a>
							# } else { #
								<a data-action="view" data-id="#=id#" href="javascript:void(0);" class="icon">
									<span><?=t("Переглянути")?></span>
								</a>
							# } #
						</div>
					</div>
				</script>
				<script type="text/x-kendo-template">
					<tr>
						<td colspan="5">
							<div class="p30 tacenter"><?=t("Немає записів")?></div>
						</td>
					</tr>
				</script>
			</table>
		</div>

		<div class="mt30">
			<div><?=t("Всього")?>: <?=$pager->getTotal()?></div>
		</div>

		<? if($pager->getPages() > 1){ ?>
			<div class="mt30">

				<div class="paginator">

					<? $__current = $pager->getPage() ?>
					<? $__count = $pager->getPages() ?>

					<? parse_str(parse_url(Uri::getUrn(), PHP_URL_QUERY), $__query) ?>
					<? if( ! isset($__query["page"])){ $__query["page"] = ""; } ?>

					<div>
						<? $__query["page"] = $__current - 1 ?>
						<a href="<? if($__current > 1){ ?>?<?=http_build_query($__query)?><? } else { ?>javascript:void(0)<? } ?>"
						   class="arrow<? if( ! ($__current > 1)){ ?> disabled<? } ?>">
							<i class="icon-chevron-left"></i>
						</a>
					</div>

					<div>
						<ul>
							<? $__length = $__count > 5 ? 5 : $__count ?>
							<? $__start = $__current - round($__length / 2) ?>
							<? $__end = $__current + intval($__length / 2); ?>

							<? if($__start < 0){ ?>
								<? $__end += abs($__start) ?>
								<? $__start = 0 ?>
							<? } ?>

							<? if($__end > $__count){ ?>
								<? $__start -= ($__end - $__count) ?>
								<? $__end = $__count ?>
							<? } ?>

							<? if($__start >= 1){ ?>
								<li>
									<? $__query["page"] = 1 ?>
									<a href="?<?=http_build_query($__query)?>">1</a>
								</li>
								<? if($__start > 1){ ?>
									<li>...</li>
								<? } ?>
							<? } ?>

							<? for($__i = $__start; $__i < $__end; $__i++){ ?>
								<li>
									<? $__query["page"] = $__i + 1 ?>
									<a href="?<?=http_build_query($__query)?>"<? if($__i + 1 == $__current){ ?> class="current"<? } ?>><?=($__i + 1)?></a>
								</li>
							<? } ?>

							<? if($__end <= $__count - 1){ ?>
								<? if($__end < $__count - 1){ ?>
									<li>...</li>
								<? } ?>
								<li>
									<? $__query["page"] = $__count ?>
									<a href="?<?=http_build_query($__query)?>"><?=$__count?></a>
								</li>
							<? } ?>
						</ul>
					</div>

					<div>
						<? $__query["page"] = $__current + 1 ?>
						<a href="<? if($__current < $__count){ ?>?<?=http_build_query($__query)?><? } else { ?>javascript:void(0)<? } ?>"
						   class="arrow<? if( ! ($__current < $__count)){ ?> disabled<? } ?>">
							<i class="icon-chevron-right"></i>
						</a>
					</div>

				</div>

			</div>
		<? } ?>

	</div>

</div>
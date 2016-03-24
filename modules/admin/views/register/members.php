<div data-uiBox="toolbar">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td>
					<div><?=t("Єл. пошта чи ім'я та прізвище")?></div>
					<div class="mt5">
						<input type="text" id="q" value="<?=isset($filter["q"]) ? $filter["q"] : "" ?>" class="textbox" style="width: 250px" />
					</div>
				</td>

				<td class="pl15">
					<div><?=t("Статус")?></div>
					<div class="mt5">
						<select data-ui="type" data-value="<?=isset($filter["type"]) ? $filter["type"] : 0 ?>">
							<option value="0">&mdash;</option>
							<? foreach(UserClass::i()->getTypes() as $type){ ?>
								<? if( ! in_array($type["id"], [50, 99, 100])){ continue; } ?>
								<option value="<?=$type["id"]?>"><?=$type["text"]?></option>
							<? } ?>
						</select>
					</div>
				</td>
				
				<? if(isset($filter["type"]) && in_array($filter["type"], [99, 100])){ ?>
					<td class="pl15">
						<div><?=t("Рішення")?></div>
						<div class="mt5">
							<select data-ui="verification" data-value="<?=isset($filter["verification"]) ? $filter["verification"] : 0 ?>">
								<option value="0">&mdash;</option>
								<? foreach(array(
									99 => [
										["id" => 1, "text" => "Попередня рекомендація"],
										["id" => 2, "text" => "Рекомендовано"],
										["id" => -1, "text" => "Відхилена рекомендація"]
									],
									100 => [
										["id" => 10, "text" => "Підтверджено"],
										["id" => 9, "text" => "Призупинено членство"],
										["id" => -10, "text" => "Виключений з членства партії"],
									]
								)[$filter["type"]] as $verification){ ?>
									<option value="<?=$verification["id"]?>"><?=$verification["text"]?></option>
								<? } ?>
							</select>
						</div>
					</td>
				<? } ?>
				
				<td width="99%"></td>
				
				<td>
					<div>&nbsp;</div>
					<div class="mt5">
						<a data-action="export" href="javascript:void(0);" class="icon">
							<span><?=t("Експорт")?></span>
							<i class="icon-document fs20"></i>
						</a>
					</div>
				</td>
				
			</tr>
			<tr>
				<? if( ! (count($registerUser["geo_koatuu_code"]) > 0)){ ?>
					<td>
						<div class="mt15"><?=t("Область")?></div>
						<div class="mt5" style="width: 250px">
							<select data-ui="region" data-value="<?=isset($filter["region"]) ? $filter["region"] : 0 ?>" style="width: 250px">
								<option value="0">&mdash;</option>
								<? foreach(OldGeoClass::i()->getRegions() as $region){ ?>
									<option value="<?=$region["id"]?>"><?=$region["title"]?></option>
								<? } ?>
							</select>
						</div>
					</td>
				<? } ?>

				<? if( isset($filter["region"]) ){ ?>
					<td class="pl15">
						<div class="mt15"><?=t("Район")?></div>
						<div class="mt5">
							<select data-ui="area" data-value="<?=isset($filter["area"]) ? $filter["area"] : 0 ?>">
								<option value="0">&mdash;</option>
								<? foreach(OldGeoClass::i()->getAreas(2, $filter["region"]) as $region){ ?>
									<option value="<?=$region["id"]?>"><?=$region["title"]?></option>
								<? } ?>
							</select>
						</div>
					</td>
				<? } ?>

				<? if( isset($filter["region"]) && ! isset($filter["area"]) ){ ?>
					<td class="pl15">
						<div class="mt15"><?=t("Місто")?></div>
						<div class="mt5">
							<select data-ui="city" data-value="<?=isset($filter["city"]) ? $filter["city"] : 0 ?>">
								<option value="0">&mdash;</option>
								<? foreach(OldGeoClass::i()->getCities(2, $filter["region"]) as $city){ ?>
									<option value="<?=$city["id"]?>"><?=$city["title"]?></option>
								<? } ?>
							</select>
						</div>
					</td>
				<? } ?>

				<? if( isset($filter["area"]) && ! isset($filter["city"])){ ?>
					<td class="pl15">
						<div class="mt15"><?=t("Місто")?></div>
						<div class="mt5">
							<select data-ui="cityArea" data-value="<?=isset($filter["cityArea"]) ? $filter["cityArea"] : 0 ?>">
								<option value="0">&mdash;</option>
								<? foreach(OldGeoClass::i()->getCities(2, $filter["region"], $filter["area"]) as $city){ ?>
									<option value="<?=$city["id"]?>"><?=$city["title"]?></option>
								<? } ?>
							</select>
						</div>
					</td>
				<? } ?>
			</tr>
		</tbody>
	</table>
</div>

<div class="mt15">
	<table data-ui="list">
		<script id="data">(<?=json_encode([
			"columns" => array(
				["title" => "ID", "width" => "10%"],
				["title" => "", "width" => "5%"],
				["title" => t("Інформація")],
				["title" => t("Статус")],
				["title" => t("Дії"), "width" => "20%"],
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
			<div class="tacenter">
				# if(verification != null && verification.type != 0){ #
					<div class="icon">
						# if(verification.type > 0){ #
							<i class="icon-ok" style="padding: 0; color: #=(function(type){
								var __color = "gray";
								switch(type){
									case "1":
										__color = "orange";
										break;
									case "2":
										__color = "blue";
										break;
									case "9":
										__color = "pink";
										break;
									case "10":
										__color = "green";
										break;
								}
								return __color;
							}(verification.type))#"></i>
						# } else if(verification.type < 0) { #
							<i class="icon-remove" style="padding: 0; color: red"></i>
						# } #
					</div>
				# } #
			</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="p5">
				<div>
					<a href="/profile/#=id#" target="_blank">#=name#</a>
				</div>
				# if(typeof locality == "string"){ #
					<div>#=locality#</div>
				# } #
			</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="tacenter">#=(function(typeId){
				__typeText = "";
				(<?=json_encode(UserClass::getTypes())?>).forEach(function(item){
					if(item.id != typeId)
						return;
					__typeText = item.text;
				});
				return __typeText;
			}(type))#</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="tacenter">
				<a data-action="view" data-id="#=id#" href="javascript:void(0);"><?=t("Переглянути")?></a>
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
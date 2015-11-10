<div>
	<h2 style="white-space: nowrap"><?=t("Доступ до реєстру")?></h2>
</div>

<div data-uiBox="toolbar" class="mt15">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td width="">
					<div><?=t("Група")?></div>
					<div class="mt5">
						<select data-ui="credential_levels"<? if(isset($filter["cl"])){ ?> data-value="<?=$filter["cl"]?>"<? } ?>>
							<? foreach(RegisterUsersModel::i()->getCredentialLevels() as $__id => $__credentialLevel){ ?>
								<option value="<?=$__id?>"><?=t($__credentialLevel["title"])?></option>
							<? } ?>
						</select>
					</div>
				</td>

				<td class="pl15">
					<div><?=t("Регіон")?></div>
					<div class="mt5">
						<select data-ui="regions"<? if(isset($filter["r"])){ ?> data-value="<?=$filter["r"]?>"<? } ?>>
							<option value="0">&mdash;</option>
							<? foreach(OldGeoClass::i()->getRegions() as $__region){ ?>
								<option value="<?=$__region["id"]?>"><?=$__region["title"]?></option>
							<? } ?>
						</select>
					</div>
				</td>
				
				<td width="99%"></td>
				
				<td>
					<div>&nbsp;</div>
					<div class="mt5">
						<a data-action="add" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Долучити")?></a>
					</div>
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
				["title" => t("Фото"), "width" => "60px"],
				["title" => t("Інформація")],
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
			<div class="p5">
				<div class="avatar avatar-2x"# if(user.avatar != ""){ # style="background-image: url('/s/img/thumb/ai/#=user.avatar#')"# } #>
					# if(user.avatar == ""){ #
						<i class="icon-user"></i>
					# } #
				</div>
			</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="p5">
				<div>
					<a href="/profile/#=user_id#" target="_blank">#=user.first_name# #=user.last_name#</a>
				</div>
				# if(typeof region != "undefined"){ #
					<div class="mt5">
						<span>#=region.title#</span>
					</div>
				# } #
				<div class="mt5">
					<span>#=credential_level_title#</span>
				</div>
			</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="tacenter">
				<div><a data-action="edit" data-id="#=id#" href="javascript:void(0);"><?=t("Змінити")?></a></div>
				<div><a data-action="remove" data-id="#=id#" href="javascript:void(0);"><?=t("Видалити")?></a></div>
			</div>
		</script>
		<script type="text/x-kendo-template">
			<tr>
				<td colspan="4">
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
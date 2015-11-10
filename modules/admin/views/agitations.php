<script id="data">(<?=json_encode(array(
	"table#list" => array(
		"columns" => array(
			array("title" => "ID", "width" => "5%"),
			array("title" => t("Інформація")),
			array("title" => t("Публічна"), "width" => "10%"),
			array("title" => t("Дії"), "width" => "15%"),
		),
		"dataSource" => array(
			"data" => $list,
			"schema" => array(
				"model" => array(
					"id" => "id"
				)
			)
		)
	)
))?>);</script>

<div class="header">
	<div>
		<h1>
			<a href="/admin"><?=t("Адмін панель")?></a> / <?=t(AgitationsAdminController::$modAText)?>
		</h1>
	</div>
</div>

<div class="section">
	<div>
		
		<div class="mb15">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						
						<td>
							<div class="tabbar">
								<ul>
									<li<? if(in_array($filter["type"], ["", "all"])){ ?> class="selected"<? } ?>>
										<a href="/admin/agitations"><?=t("Загальна")?></a>
									</li>
									<li<? if($filter["type"] == "election"){ ?> class="selected"<? } ?>>
										<a href="/admin/agitations/election"><?=t("Вибори 2014")?></a>
									</li>
								</ul>
							</div>
						</td>
						
					</tr>
				</tbody>
			</table>
		</div>
		
		<div data-uiBox="toolbar">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>

						<td>
							<a data-action="create" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Створити")?></a>
						</td>

					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="mt15">
			<table data-ui="list" width="100%">
				<script id="data">(<?=json_encode([
					"columns" => array(
						["title" => "ID", "width" => "5%"],
						["width" => "100px"],
						["title" => t("Інформація")],
						["title" => t("Публічна"), "width" => "10%"],
						["title" => t("Дії"), "width" => "15%"],
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
					<div class="preview" style="background-image: url('/s/img/thumb/aa/#=image#'); height: 100px"></div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p15">
						<div class="fwbold">#=name.<?=Router::getLang()?>#</div>
						<div class="mt5">#=categories.join(", ")#</div>
						<div class="mt5 fs12"><?=t("Дата публікаціЇ")?>: #=kendo.toString(kendo.parseDate(created_at), "dd MMMM yyyy")#</div>
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">
						<input type="checkbox" data-action="publicate" data-id="#=id#"# if(is_public == 1){ # checked# } # />
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">
						<div>
							<a href="javascript:void(0);" data-action="edit" data-id="#=id#"><?=t("Змінити")?></a>
						</div>
						<div>
							<a href="javascript:void(0);" data-action="delete" data-id="#=id#" data-text="<?=t("Ви дійсно бажаєте видалити цю агітацію?")?>"><?=t("Видалити")?></a>
						</div>
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
		
	</div>
</div>

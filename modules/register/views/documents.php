<? include "common/header.php"; ?>

<div class="section">
	<div>

		<? include "common/tabs.php"; ?>

		<div data-uiBox="toolbar">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>
					<td>
						<a data-action="create" href="javascript:void(0);" class="v-button v-button-blue"><i class="icon icon-document"></i> <?=t("Створити")?></a>
						<a data-action="manage_categories" href="javascript:void(0);" class="v-button v-button-blue ml10"><?=t("Категорії")?></a>
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
				["title" => t("Інформація")],
				["title" => t("К-ть"), 'width' => "6%"],
				["title" => t("Дії"), "width" => "11%"],
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
					<div class="p5"><b>#=title#</b></div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5 tacenter" data-uiBox="images">
						#=images.length#
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">
						<a data-action="edit" data-id="#=id#" href="javascript:void(0);"><i class="icon icon-pencil"></i> <?=t("Редагувати")?></a>
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

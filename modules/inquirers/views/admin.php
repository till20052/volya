<? include "common/header.php"; ?>

<div class="section">
	<div>

		<div data-uiBox="toolbar">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>

					<td>
						<a data-action="create" href="javascript:void(0);" class="v-button button-yellow">
							<i class="icon icon-plus-sign"></i>
							<?=t("Створити")?>
						</a>
					</td>

				</tr>
				</tbody>
			</table>
		</div>

		<div class="mt15">
			<table data-ui="forms" width="100%">
				<script id="data">(<?=json_encode([
						"columns" => array(
							["title" => "ID", "width" => "5%"],
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
					<div class="p5" style="line-height:normal">
						<div class="fwbold"><a href="/inquirers/answers/#=id#" target="_blank">#=title#</a></div>
						<div class="mt5 fs12"><?=t("Дата публікаціЇ")?>: #=kendo.toString(kendo.parseDate(created_at), "HH:mm dd MMMM yyyy")#</div>
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
							<a href="javascript:void(0);" data-action="delete" data-id="#=id#" data-text="<?=t("Ви дійсно бажаєте видалити цю новину?")?>"><?=t("Видалити")?></a>
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

					<div>
						<a href="<? if($__current > 1){ ?>?page=<?=($__current - 1)?><? } else { ?>javascript:void(0)<? } ?>"
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
									<a href="?page=1">1</a>
								</li>
								<? if($__start > 1){ ?>
									<li>...</li>
								<? } ?>
							<? } ?>

							<? for($__i = $__start; $__i < $__end; $__i++){ ?>
								<li>
									<a href="?page=<?=($__i + 1)?>"<? if($__i + 1 == $__current){ ?> class="current"<? } ?>><?=($__i + 1)?></a>
								</li>
							<? } ?>

							<? if($__end <= $__count - 1){ ?>
								<? if($__end < $__count - 1){ ?>
									<li>...</li>
								<? } ?>
								<li>
									<a href="?page=<?=$__count?>"><?=$__count?></a>
								</li>
							<? } ?>
						</ul>
					</div>

					<div>
						<a href="<? if($__current < $__count){ ?>?page=<?=($__current + 1)?><? } else { ?>javascript:void(0)<? } ?>"
						   class="arrow<? if( ! ($__current < $__count)){ ?> disabled<? } ?>">
							<i class="icon-chevron-right"></i>
						</a>
					</div>

				</div>

			</div>
		<? } ?>

	</div>
</div>
<div data-uiBox="toolbar">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>

			<td>
				<a data-action="create_block" href="javascript:void(0);" class="v-button button-yellow">
					<i class="icon icon-plus-sign"></i>
					<?=t("Додати блок")?>
				</a>
			</td>

		</tr>
		</tbody>
	</table>
</div>

<div class="mt15">
	<table data-ui="blocks" width="100%">
		<script id="data">(<?=json_encode([
				"columns" => array(
					["title" => "ID", "width" => "5%"],
					["title" => t("Назва блоку проблем")],
					["title" => t("Публічний"), "width" => "15%"],
					["title" => t("Дії"), "width" => "15%"],
				)
			])?>);</script>
		<script type="text/x-kendo-template">
			<div class="tacenter">#=id#</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="p5" style="line-height:normal">
				<div class="fwbold">#=title#</div>
			</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="tacenter">
				<input type="checkbox" data-action="publicate" data-id="#=id#"# if(is_public == 1){ # checked# } # />
			</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="tacenter pt5 pb5">
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
	<div><?=t("Всього")?>: <span id="total_blocks"></span></div>
</div>
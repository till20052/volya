<div data-uiBox="toolbar">
	<div class="mt10">
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>

			<tr>
				<td style="width: 115px" class="taright pr15"><?=t("Назва блоку")?></td>
				<td>
					<input type="text" data-ui="block_title" class="textbox" style="width:100%" placeholder="Введіть назву блоку або оберіть з існуючих" />
				</td>
				<td style="width: 170px" class="pl5">
					<a data-action="add_block" href="javascript:void(0);" class="v-button button-yellow">
						<i class="icon icon-plus-sign"></i>
						<?=t("Додати блок")?>
					</a>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="cgray"><?=t("Введіть назву блоку або оберіть з існуючих")?></span>
				</td>
				<td></td>
			</tr>

			</tbody>
		</table>
	</div>
</div>

<div class="mt15">
	<table data-ui="blocks" width="100%">
		<script id="data">(<?=json_encode([
				"columns" => array(
					["title" => "ID", "width" => "5%"],
					["title" => t("Назва блоку проблем")],
					["title" => t("Дії"), "width" => "15%"],
				)
			])?>);</script>
		<script type="text/x-kendo-template">
			<div class="tacenter">#=id#</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="p5" style="line-height:normal">
				<div class="fwbold" data-id="#=id#" data-action="edit">#=title#</div>
			</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="tacenter pt5 pb5">
				<div>
					<a href="javascript:void(0);" data-action="add_questions" data-id="#=id#"><?=t("Змінити")?></a>
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
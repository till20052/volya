<table data-ui="supporters" width="100%">
	<script id="data">(<?=json_encode([
			"columns" => array(
				["title" => "ID", "width" => "5%"],
				["title" => t("Інформація")],
				["title" => t("Тип запису"), "width" => "20%"],
				["title" => t("Дії"), "width" => "15%"],
			),
			"dataSource" => [
				"data" => $supporters,
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
			<div class="fwbold">#=name.value#</div>
			<div class="mt5 fs12"><?=t("Зареєстровано")?>: #=kendo.toString(kendo.parseDate(created_at), "HH:mm dd MMMM yyyy")#</div>
		</div>
	</script>
	<script type="text/x-kendo-template">
		<div class="tacenter">#=type#</div>
	</script>
	<script type="text/x-kendo-template">
		<div class="tacenter">
			<div>
				<a href="javascript:void(0);" data-action="view" data-id="#=id#"><?=t("Переглянути")?></a>
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
<div>
	<a data-action="add_agitation" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Додати матеріал")?></a>
</div>
<div class="mt5">
	<table data-ui="agitations">
		<script id="data">(<?=json_encode([
			"columns" => array(
				["width" => "100px"],
				["title" => t("Інформація")],
				["title" => t("П"), "width" => "10%"],
				["title" => t("Дії"), "width" => "20%"],
			),
			"dataSource" => [
				"data" => [],
				"scheme" => [
					"model" => ["id" => "id"]
				]
			]
		])?>);</script>
		<script type="text/x-kendo-template">
			<div class="preview" style="background-image: url('/s/img/thumb/aa/#=image#'); height: 100px"></div>
		</script>
		<script type="text/x-kendo-template">
			<div class="p15">
				<div class="fwbold">#=name.<?=Router::getLang()?>#</div>
				<div class="mt5">#=categories.join(", ")#</div>
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
					<a data-action="edit" data-id="#=id#" href="javascript:void(0);"><?=t("Змінити")?></a>
				</div>
				<div>
					<a data-action="delete" data-id="#=id#" href="javascript:void(0);"><?=t("Видалити")?></a>
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
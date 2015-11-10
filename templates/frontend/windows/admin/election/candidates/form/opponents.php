<div>
	<a data-action="add_opponent" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Додати")?></a>
</div>
<div class="mt5">
	<table data-ui="opponents">
		<script id="data">(<?=json_encode([
			"columns" => array(
				["width" => "100px"],
				["title" => t("Інформація")],
				["title" => t("О"), "width" => "10%"],
				["title" => t("Л"), "width" => "10%"],
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
			<div class="preview" style="background-image: url('/s/img/thumb/aa/#=symlink_avatar#'); height: 100px"></div>
		</script>
		<script type="text/x-kendo-template">
			<div class="p15">
				<div class="fwbold">#=name#</div>
			</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="tacenter">
				<input type="radio" name="type-#=id#" data-action="set_type" data-id="#=id#" data-value="1"# if(type == 1){ # checked# } # />
			</div>
		</script>
		<script type="text/x-kendo-template">
			<div class="tacenter">
				<input type="radio" name="type-#=id#" data-action="set_type" data-id="#=id#" data-value="2"# if(type == 2){ # checked# } # />
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
					<a data-action="delete" data-id="#=id#" data-text="<?=t("Ви дійсно бажаєте видалити ")?>#=name#?" href="javascript:void(0);"><?=t("Видалити")?></a>
				</div>
			</div>
		</script>
		<script type="text/x-kendo-template">
			<tr>
				<td colspan="6">
					<div class="p30 tacenter"><?=t("Немає записів")?></div>
				</td>
			</tr>
		</script>
	</table>
</div>
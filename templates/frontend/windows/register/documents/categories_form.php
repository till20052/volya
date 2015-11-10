<div ui-window="register.documents.categories_form" style="width: 650px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Категорії до документiв")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<div>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>

					<tr>
						<td width="25%" align="right" class="tacenter"><?=t("Назва нової категорії")?></td>
						<td>
							<input type="text" id="title" class="textbox" style="width:100%" />
						</td>
						<td width="25%" class="pl10">
							<a data-action="add" href="javascript:void(0);" class="v-button"><?=t("Створити")?></a>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		
		<div class="mt15">
			<table data-ui="list">
				<script id="data">(<?=json_encode([
					"columns" => array(
						["title" => "ID", "width" => "10%"],
						["title" => t("Назва категорії")],
					),
					"dataSource" => [
						"data" => [],
						"scheme" => [
							"model" => ["id" => "id"]
						]
					]
				])?>);</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">#=id#</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p10">
						<a data-action="edit" data-id="#=id#" href="javascript:void(0);">#=title#</a>
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
		
	</div>
	
</div>
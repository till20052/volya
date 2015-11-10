<div ui-window="cells.index.common.right_column.add_event" style="width: 600px">
	<script id="data">(<?=json_encode(array(
		"cell" => array("id" => $cell["id"])
	))?>);</script>
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Подія")?></h2>
	</div>
	
	<div class="mt15">
		
		<div>
			<div class="fwbold"><?=t("Заголовок")?></div>
			<div class="mt5">
				<input type="text" id="title" class="textbox x2" />
			</div>
		</div>
		
		<div class="mt15">
			<textarea data-ui="description" placeholder="<?=t("Зміст події")?>" class="textbox" style="min-height: 200px; resize: vertical"></textarea>
		</div>
		
		<div class="mt15">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						
						<td width="25%" class="taright fwbold pr15"><?=t("Дата")?></td>
						<td width="50%">
							<input type="text" data-uiDateTimePicker="happen_at" style="width: 100%" />
						</td>
						<td>&nbsp;</td>
						
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="mt15 tacenter">
			<input type="button" id="add" value="<?=t("Створити")?>" class="button blue x2" />
		</div>
		
	</div>
	
</div>
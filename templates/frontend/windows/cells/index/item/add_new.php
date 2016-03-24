<div ui-window="cells.index.item.add_new" style="width: 600px">
	<script id="data">(<?=json_encode(array(
		"cell" => array("id" => $cell["id"])
	))?>);</script>
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Новина")?></h2>
	</div>
	
	<div class="mt15">
		
		<div>
			<div class="fwbold"><?=t("Заголовок")?></div>
			<div class="mt5">
				<input type="text" id="title" class="textbox x2" />
			</div>
		</div>
		
		<div class="mt15">
			<textarea data-ui="text" placeholder="<?=t("Зміст новини")?>" class="textbox" style="min-height: 200px; resize: vertical"></textarea>
		</div>
		
		<div class="mt15 tacenter">
			<input type="button" id="add" value="<?=t("Додати")?>" class="button blue x2" />
		</div>
		
	</div>
	
</div>
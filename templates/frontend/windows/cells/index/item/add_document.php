<div ui-window="cells.index.item.add_document" style="width: 400px">
	<script id="data">(<?=json_encode(array(
		"cell" => array(
			"id" => $cell["id"]
		),
		"document_types" => $documentTypes
	))?>);</script>
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Новий документ")?></h2>
	</div>
	
	<div class="mt15">
		
		<div>
			<div class="fwbold"><?=t("Назва документу")?></div>
			<div class="mt5">
				<input type="text" id="name" class="textbox x2" />
			</div>
		</div>
		
		<div class="mt5">
			<div class="fwbold"><?=t("Тип")?></div>
			<div class="mt5">
				<select data-ui="type" style="width: 100%"></select>
			</div>
		</div>
		
		<div class="mt30 mb25 tacenter">
			<div data-uiFileUpload="document" class="fileupload x2" style="display: block">
				<div>
					<input type="file" name="document" />
					<div class="tacenter"><?=t("Завантажити файл")?></div>
				</div>
				<div>
					<div style="padding: 15px">
						<div style="display: table; width: 100%">
							<div style="display: table-cell; width: 30px; vertical-align: middle">
								<i class="icon-file" style="font-size: 20px"></i>
							</div>
							<div style="display: table-cell; vertical-align: middle">
								<span data-uiLabel="name">file name</span>
							</div>
							<div class="taright" style="display: table-cell; width: 30px; vertical-align: middle">
								<a data-uiAction="remove" href="javascript:void(0);" class="icon">
									<i class="icon-remove" style="padding: 0"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="tacenter">
			<input type="button" id="add" value="<?=t("Додати")?>" class="button blue x2" />
		</div>
		
	</div>
	
</div>
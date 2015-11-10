<div ui-window="admin.news.categories" style="width: 700px">
	
	<script id="data">(<?=json_encode(array(
		"table#list" => array(
			"columns" => array(
				array("title" => t("Посилання")),
				array("title" => t("Найменування")),
				array("title" => t("По замовчуванню"), "width" => "15%"),
				array("title" => t("Публічна"), "width" => "12%"),
				array("width" => "5%"),
			),
			"dataSource" => array(
				"schema" => array(
					"model" => array(
						"id" => "id"
					)
				)
			)
		)
	))?>)</script>
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Категорії")?></h2>
	</div>
	
	<div class="mt10">
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					<td width="25%" align="right" class="tacenter"><?=t("Назва нової категорії")?></td>
					<td>
						<input type="text" id="name" class="k-textbox" style="width:100%" />
					</td>
					<td width="25%" class="pl10">
						<input type="button" id="add" value="<?=t("Створити")?>" class="k-button" style="width:100%" />
					</td>
				</tr>
				
			</tbody>
		</table>
	</div>
	
	<div class="mt10">
		<table id="list">
			<script type="text/x-kendo-template">
				<div style="padding:0 10px;line-height:normal">
					<div style="padding:10px 0">
						# if(is_system == 0){ #<a href="javascript:void(0)" ui="symlink" data-id="#=id#"># } ##=(symlink != "" ? symlink : "[ no value ]")## if(is_system == 0){ #</a># } #
					</div>
				</div>
			</script>
			<script type="text/x-kendo-template">
				<div style="padding:0 10px;line-height:normal">
					<div style="padding:10px 0">
						# if(is_system == 0){ # <a href="javascript:void(0)" ui="name" data-id="#=id#"># } # #=(name.<?=Router::getLang()?> != "" ? name.<?=Router::getLang()?> : "[ no value ]")## if(is_system == 0){ #</a># } #
					</div>
				</div>
			</script>
			<script type="text/x-kendo-template">
				<div class="tacenter">
					<input type="radio" name="default[]" ui="default" data-id="#=id#"# if(is_default == 1){ # checked# } # />
				</div>
			</script>
			<script type="text/x-kendo-template">
				<div class="tacenter">
					<input type="checkbox" ui="public" data-id="#=id#"# if(is_public == 1){ # checked# } # />
				</div>
			</script>
			<script type="text/x-kendo-template">
				<div class="pl10 fs12">
					<div>
						# if(is_system == 0){ # <a href="javascript:void(0);" ui="remove" data-id="#=id#"><i class="icon-remove"></i></a># } #
					</div>
				</div>
			</script>
		</table>
	</div>
	
</div>
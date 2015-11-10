<div ui-window="volyaspeople.form" style="width: 400px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Додати людину")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<div class="tacenter">
			<div data-ui="avatar" class="avatar avatar-8x">
				<div class="avatar avatar-8x">
					<input type="file" name="file" />
					<i class="icon-uploadalt"><?=t("Завантажити")?><br /><?=t("фото")?></i>
				</div>
				<i class="icon-user"></i>
			</div>
		</div>
		
		<div class="mt30">
			<div><?=t("Ім'я та Прізвище")?></div>
			<div class="mt5">
				<input type="text" id="name" class="textbox" style="width: 100%" />
			</div>
		</div>
		
		<div class="mt15">
			<div><?=t("Короткий опис")?></div>
			<div class="mt5">
				<textarea id="description" class="textbox" style="width: 100%; height: 100px; resize: vertical"></textarea>
			</div>
		</div>
		
		<div class="mt15">
			<div class="tacenter">
				<a href="javascript:void(0);" data-action="upload_video"><?=t("Завантажити відео")?></a>
			</div>
		</div>
		
		<div class="mt15 tacenter">
			<a href="javascript:void(0);" data-action="submit" class="v-button v-button-blue"><?=t("Долучити")?></a>
		</div>
		
	</div>
	
</div>
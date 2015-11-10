<div ui-window="admin.election.candidates.opponent_form" style="width: 400px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Редагування")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<div>
			<div data-ui="avatar" class="avatar avatar-8x">
				<div class="avatar avatar-8x">
					<input type="file" name="file" />
					<i class="icon-uploadalt"><?=t("Завантажити")?><br /><?=t("фото")?></i>
				</div>
				<i class="icon-user"></i>
			</div>
		</div>
		
		<div class="mt15">
			<div><?=t("Ім'я")?></div>
			<div>
				<input type="text" id="name" class="textbox" style="width: 100%" />
			</div>
		</div>
		
		<div class="mt15">
			<div><?=t("Тип")?></div>
			<div>
				<select data-ui="type" style="width: 100%">
					<option value="0">&mdash;</option>
					<option value="1"><?=t("Конкурент")?></option>
					<option value="2"><?=t("Буде люстрований")?></option>
				</select>
			</div>
		</div>
		
		<div class="mt15">
			<div><?=t("Посада")?></div>
			<div>
				<textarea id="appointment" class="textbox" style="width: 100%; height: 100px; resize: vertical"></textarea>
			</div>
		</div>
		
		<div class="mt15">
			<div><?=t("Опис")?></div>
			<div>
				<textarea id="description" class="textbox" style="width: 100%; height: 100px; resize: vertical"></textarea>
			</div>
		</div>
		
		<div class="mt15 tacenter">
			<a data-action="submit" href="javascript:void(0);" class="v-button v-button-blue mr5"><?=t("Зберегти")?></a><!--
			--><a data-action="cancel" href="javascript:void(0);" class="v-button"><?=t("Відміна")?></a>
		</div>
		
	</div>
	
</div>
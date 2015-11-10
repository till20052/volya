<div ui-window="admin.register.members.verification" style="width: 500px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Рішення")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<div data-uiBox="decision_number" class="mb15">
			<div><?=t("Номер рішення")?></div>
			<div>
				<input type="text" id="decision_number" class="textbox" style="width: 100%" />
			</div>
		</div>
		
		<div data-uiBox="comment">
			<div><?=t("Коментар")?></div>
			<div>
				<textarea id="comment" class="textbox" style="height: 100px; resize: vertical"></textarea>
			</div>
		</div>
		
		<div class="mt15 pb10 tacenter">
			<a id="submit" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Рекомендувати")?></a>
			<a id="cancel" href="javascript:void(0);" class="v-button"><?=t("Відміна")?></a>
		</div>
		
	</div>
	
</div>
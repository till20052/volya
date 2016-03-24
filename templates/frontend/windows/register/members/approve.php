<div ui-window="register.members.approve" style="width: 500px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Прийняття")?></h2>
	</div>
	
	<div class="mt15 fs14">

		<div data-uiBox="decision_number" class="mb15">
			<div><?=t("Дата прийняття рішення")?></div>
			<div>
				<input id="created_at" type="text" style="width: 245px;" />
			</div>
		</div>

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
			<a id="submit" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Прийняти")?></a>
			<a id="cancel" href="javascript:void(0);" class="v-button"><?=t("Відхилити")?></a>
		</div>
		
	</div>
	
</div>
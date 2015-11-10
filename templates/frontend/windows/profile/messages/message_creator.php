<div ui-window="profile.messages.message_creator" style="width: 500px">
	
	<script id="data">
		(<?=json_encode(array(
			"select[ui='receivers']" => array(
				"dataValueField" => "id",
				"dataTextField" => "name",
				"dataSource" => array(
					"data" => $friends
				)
			)
		))?>);
	</script>
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Нове повідомлення")?></h2>
	</div>
	
	<form action="/profile/messages/j_add_message" method="post">
		<div class="mt15">
			<div class="p5">
				<h3><?=t("Одержувач")?></h3>
			</div>
			<div>
				<select ui="receivers" style="width:100%"></select>
			</div>
		</div>
		
		<div class="mt15">
			<div class="p5">
				<h3><?=t("Тема")?></h3>
			</div>
			<div>
				<input type="text" id="subject" class="k-textbox" style="width:100%" />
			</div>
		</div>

		<div class="mt15">
			<div class="p5">
				<h3><?=t("Повідомлення")?></h3>
			</div>
			<div>
				<textarea id="message" class="k-textbox" style="width:100%;height:200px;resize:vertical"></textarea>
			</div>
		</div>

		<div class="mt15 tacenter">
			<a href="javascript:void(0);" id="send_message" class="v-button v-button-yellow"><?=t("Відправити")?></a>
		</div>
	</form>
	
</div>
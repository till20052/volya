<div ui-window="inquirers.admin.answers" style="width: 700px">

		<div class="fright">
			<a class="closeButton"></a>
		</div>

		<div>
			<h2><?=t("Варіанти відповідей")?></h2>
		</div>

		<table width="100%" cellspacing="0" cellpadding="0" class="mt10 mb10">
			<tr>
				<td style="width: 100px" class="taright pr15"><?=t("Питання")?></td>
				<td class="pr10">
					<span data-ui="question"></span>
				</td>
			</tr>
		</table>

		<div data-section="answers" class="mt10">
			<div>
				<div class="mt10">
					<table width="100%" cellspacing="0" cellpadding="0">
						<tbody>

						<tr>
							<td style="width: 150px" class="taright pr15"><?=t("Тип питання")?></td>
							<td style="width: 203px" class="pl10" colspan="2">
								<select data-ui="answers_type" style="width:100%">
									<option value="1"><?=t("Одна з декількох")?></option>
									<option value="2"><?=t("Декілька")?></option>
								</select>
							</td>
						</tr>

						<tr><td colspan="3" style="height:10px"></td></tr>

						<tr data-box="answers_num" class="dnone">
							<td class="taright pr15"><?=t("Кількість можливих відповідей")?></td>
							<td class="pl10" colspan="2">
								<input type="number" data-ui="answers_num" style="width:100%">
							</td>
						</tr>

						<tr><td colspan="3" style="height:10px"></td></tr>

						<tr>
							<td colspan="2">
								<input type="text" id="answer_title" class="textbox" style="width:100%" placeholder="<?=t("Відповідь")?>" />
							</td>
							<td style="width: 203px" class="pl10">
								<a data-action="create_answer" href="javascript:void(0);" class="v-button button-yellow">
									<i class="icon icon-plus-sign"></i>
									<?=t("Додати відповідь")?>
								</a>
							</td>
						</tr>

						</tbody>
					</table>
				</div>

				<div class="mt15">
					<table data-ui="answers" width="100%">
						<script id="data">(<?=json_encode([
								"columns" => array(
									["title" => t("Відповідь")],
									["title" => t("Проблема"), "width" => "15%"],
									["title" => t("Публічна"), "width" => "12%"],
									["title" => t("Дії"), "width" => "15%"],
								)
							])?>);</script>
						<script type="text/x-kendo-template">
							<div class="p5" style="line-height:normal">
								<div class="fwbold" data-id="#=id#" data-action="edit">#=title#</div>
							</div>
						</script>
						<script type="text/x-kendo-template">
							<div class="tacenter">
								<input type="checkbox" data-action="is_problem" data-id="#=id#"# if(is_problem == 1){ # checked# } # />
							</div>
						</script>
						<script type="text/x-kendo-template">
							<div class="tacenter">
								<input type="checkbox" data-action="publicate" data-id="#=id#"# if(is_public == 1){ # checked# } # />
							</div>
						</script>
						<script type="text/x-kendo-template">
							<div class="pt5 pl5 pb5">
								<div>
									<a href="javascript:void(0);" data-action="delete" data-id="#=id#" data-text="<?=t("Ви дійсно бажаєте видалити цю новину?")?>"><i class="icon-remove mr5"></i><?=t("Видалити")?></a>
								</div>
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

				<div class="mt30">
					<div><?=t("Всього")?>: <span id="total_problems"></span></div>
				</div>

				<div class="mt30 taright">
					<a data-action="save" href="javascript:void(0);" class="v-button button-yellow mr10">
						<i class="icon icon-ok"></i>
						<?=t("Готово")?>
					</a>
				</div>

			</div>
		</div>

</div>
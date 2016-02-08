<div ui-window="inquirers.admin.blocks" style="width: 700px">

		<div class="fright">
			<a class="closeButton"></a>
		</div>

		<div>
			<h2><?=t("Блок питань")?></h2>
		</div>

		<form action="/inquirers/admin/save_block" method="post">
			<table width="100%" cellspacing="0" cellpadding="0" class="mt10 mb10">
				<tr>
					<td style="width: 100px" class="taright pr15"><?=t("Назва блоку")?><span style="padding-left: 5px; color: red">*</span></td>
					<td class="pr10">
						<input type="text" data-ui="block_title" name="title" class="textbox">
					</td>
				</tr>
			</table>
		</form>

		<div data-section="questions" class="mt10">
			<div>
				<div class="mt10">
					<table width="100%" cellspacing="0" cellpadding="0">
						<tbody>

						<tr>
							<td style="width: 100px" class="taright pr15"><?=t("Питання")?></td>
							<td>
								<input type="text" id="question_title" class="textbox" style="width:100%" />
							</td>
							<td style="width: 203px" class="pl10">
								<a data-action="create_question" href="javascript:void(0);" class="v-button button-yellow">
									<i class="icon icon-plus-sign"></i>
									<?=t("Додати питання")?>
								</a>
							</td>
						</tr>

						</tbody>
					</table>
				</div>

				<div class="mt15">
					<table data-ui="questions" width="100%">
						<script id="data">(<?=json_encode([
								"columns" => array(
									["title" => t("Питання")],
									["title" => t("Текстове"), "width" => "13%"],
									["title" => t("Публічне"), "width" => "13%"],
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
								<input type="checkbox" data-action="is_text" data-id="#=id#"# if(is_text == 1){ # checked# } # />
							</div>
						</script>
						<script type="text/x-kendo-template">
							<div class="tacenter">
								<input type="checkbox" data-action="publicate" data-id="#=id#"# if(is_public == 1){ # checked# } # />
							</div>
						</script>
						<script type="text/x-kendo-template">
							<div class="pt5 pl5 pb5">
								# if(is_text != 1){ #
									<div>
										<a href="javascript:void(0);" data-action="add_answers" data-id="#=id#"><i class="icon-circleadd mr5"></i><?=t("Відповіді")?></a>
									</div>
								# } #
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
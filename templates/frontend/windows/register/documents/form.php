<div ui-window="register.documents.form" style="width: 600px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Менеджер документiв")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<div class="mt5">
			<form action="/register/documents/j_save_document" method="post">
				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>

						<tr>
							<td width="150px" class="vacenter taright"><?=t("Категорія")?>:</td>
							<td class="pl15">
								<select data-ui="categories" style="width: 100%">
									<script>(<?=json_encode($categories)?>);</script>
								</select>
							</td>
						</tr>

						<tr>
							<td colspan="2" style="height: 15px"></td>
						</tr>

						<tr>
							<td width="150px" class="vacenter taright"><?=t("Номер")?>:</td>
							<td class="pl15">
								<input type="text" id="number" class="textbox" style="width: 100%" />
							</td>
						</tr>

						<tr>
							<td colspan="2" style="height: 15px"></td>
						</tr>

						<tr>
							<td width="150px" class="vacenter taright"><?=t("Дата прийняття")?>:</td>
							<td class="pl15">
								<input data-ui="created_at" type="text" style="width: 245px;" />
							</td>
						</tr>

						<tr>
							<td colspan="2" style="height: 15px"></td>
						</tr>

						<tr>
							<td colspan="3" class="tacenter">
								<div data-uiView="images">
									<div data-uiBox="list">
										<script type="text/x-kendo-template">
											<div data-hash="#=hash#" style="background-image: url('/s/img/thumb/160x120/#=hash#')">
												<a data-action="delete" href="javascript:void(0);" class="icon">
													<i class="icon-remove"></i>
												</a>
											</div>
										</script>
										<div></div>
									</div>
									<div data-uiBox="uploader" class="mt5">
										<a href="javascript:void(0);" class="v-button v-button-blue">
											<input type="file" name="file" multiple="true" />
											<?=t("Завантажити скан")?>
										</a>
									</div>
								</div>
							</td>
						</tr>

						<tr>
							<td colspan="2" style="height: 15px"></td>
						</tr>

						<tr>
							<td class="taright" colspan="2">
								<a data-action="cancel" href="#" class="v-button"><?=t("Відміна")?></a>
								<a data-action="save" href="#" class="v-button v-button-blue"><?=t("Зберегти")?></a>
							</td>
						</tr>

					</tbody>
				</table>
			</form>
		</div>
		
	</div>
	
</div>
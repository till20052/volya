<div data-uiFrame="confirmation" class="header">
	<div>
		<h1><?=t("Підтвердження реєстрації")?></h1>
		<h3><?=t("Для того, щоб підтвердити свою реєстрацію, будь ласка, перейдіть за посиланням у листі, який ми відправили на вашу ел. пошту ")?><span data-label="email" class="fwbold">user@volya.ua</span></h3>
	</div>
</div>

<div data-uiFrame="confirmation" class="section mt15">
	
	<div>
		<table class="layout" style="table-layout: fixed">
			<tbody>
				
				<tr>
					
					<td style="width: 60%">
						<div data-uiBox="reply_email">
							<div>
								<a href="javascript:void(0);" data-action="show_form"><?=t("Не отримали листа від нас?")?></a>
							</div>
							<div>
								<table class="layout">
									<td align="center" style="width: 10%">1.</td>
									<td>
										<div><?=t("Якщо ви помилилися при вводі ел. пошти, будь ласка, вкажіть правильну адресу")?></div>
										<div class="mt10">
											<table class="layout">
												<td valign="middle" class="pr10">
													<input type="text" id="email" class="textbox" />
												</td>
												<td valign="middle" style="width: 100px">
													<a href="javascript:void(0);" data-action="send_mail" class="v-button v-button-blue"><?=t("Відправити")?></a>
												</td>
											</table>
										</div>
									</td>
								</table>
							</div>
							<div style="border-top: 1px solid #E7E2C3">
								<table class="layout">
									<td align="center" style="width: 10%">2.</td>
									<td>
										<div><?=t("Якщо ел. пошта була вказана вірно, але ви все одно не отримали нашого повідомлення, будь ласка, перевірте папку ")?><b><?=t("Спам")?></b><?=t(" вашої поштової служби: можливо, воно помилково було поміщено туди. Якщо ви дійсно виявите повідомлення в папці ")?><b><?=t("Спам")?></b><?=t(", будь ласка, не забудьте позначити його як ")?><b><?=t("Не спам")?></b></div>
									</td>
								</table>
							</div>
						</div>
					</td>
					
					<td></td>
					
				</tr>
				
			</tbody>
		</table>
	</div>
	
</div>
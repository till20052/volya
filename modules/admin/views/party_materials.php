<div class="header">
	<div>
		<h1>
			<a href="/admin">Адмін панель</a> / <?=t(PartyMaterialsAdminController::$modAText)?>
		</h1>
	</div>
</div>

<div class="section">
	<div>

		<div data-uiBox="toolbar">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>

					<td>
						<a data-action="upload" href="javascript:void(0);" class="v-button v-button-blue">
							<input type="file" name="file" multiple="true" />
							<?=t("Завантажити")?>
						</a>
					</td>

				</tr>
				</tbody>
			</table>
		</div>

		<div class="mt15">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>

					<td class="pr15 vatop">
						<div data-ui="groups">
							<header>
								<table width="100%" cellspacing="0" cellpadding="0">
									<tbody>
									<tr>

										<td class="fwbold"><?=t("Групи")?></td>

										<td class="taright">
											<a id="add" href="javascript:void(0);"><?=t("Створити")?></a>
										</td>

									</tr>
									</tbody>
								</table>
							</header>
							<section>
								<ul>
									<script id="item" type="text/x-kendo-template">
										<li data-action="select" data-id="#=id#">
											<div>
												<div>#=name#</div>
												<div>
													<a data-action="edit" data-id="#=id#" href="javascript:void(0);" class="icon">
														<i class="icon-pencil"></i>
													</a>
													<a data-action="remove" data-id="#=id#" data-message="<?=t("Ви дійсно бажаєте видалити групу ")?><strong>#=name#</strong>?" href="javascript:void(0);" class="icon">
														<i class="icon-remove"></i>
													</a>
												</div>
											</div>
										</li>
									</script>
									<script id="empty" type="text/x-kendo-template">
										<li class="empty"><?=t("Немає груп")?></li>
									</script>
									<script id="data">(<?=json_encode($groups)?>)</script>
								</ul>
							</section>
						</div>
					</td>

					<td class="vatop" style="width: 730px">
						<div data-ui="materials">
							<section>
								<div class="onloading"></div>
								<ul>
									<script id="item" type="text/x-kendo-template">
										<li data-id="#=id#">
											<div class="onloading"></div>
											<div class="nav">
												<a data-action="remove" data-id="#=id#" data-message="<?=t("Ви дійсно бажаєте видалити файл ")?><strong>#=name#</strong>?" href="javascript:void(0);" class="icon">
													<i class="icon-remove"></i>
												</a>
												<a data-action="edit" data-id="#=id#" href="javascript:void(0);" class="icon">
													<i class="icon-pencil"></i>
												</a>
											</div>
											<div class="pic">
												<div class="icon">
													<i class="icon-file"></i>
												</div>
											</div>
											<div class="name">
												<a href="javascript:void(0);">#=name#</a>
											</div>
										</li>
									</script>
									<script id="empty" type="text/x-kendo-template">
										<li class="empty"><?=t("Немає файлів")?></li>
									</script>
								</ul>
							</section>
						</div>
					</td>

				</tr>
				</tbody>
			</table>
		</div>

	</div>
</div>
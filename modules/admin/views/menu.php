<div class="header">
	
	<div>
		
		<div>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td>
							<h1>
								<a href="/admin">Адмін панель</a> / <?=t(MenuAdminController::$modAText)?>
							</h1>
						</td>
						<td class="taright">
							<a href="javascript:void(0);" id="add" class="icon v-button v-button-blue mr10">
								<i class="icon-circleadd"></i>
								<span><?=t("Створити")?></span>
							</a><!--
							--><a href="javascript:void(0);" id="remove" class="icon v-button">
								<i class="icon-remove"></i>
								<span><?=t("Видалити")?></span>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>

</div>

<div>
	
	<div>
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					
					<td width="30%">
						<div ui-tree="menu" style="height: 500px"></div>
					</td>
					
					<td valign="top">
						<div ui-box="hide_form" style="position: absolute; background-color: rgba(255, 255, 255, .75); z-index: 1"></div>

						<form action="/admin/menu/j_save" method="post">

							<table  width="80%" cellpadding="0" cellspacing="0">

								<tbody>

									<tr>
										<td width="25%" class="taright pr10">Мова:</td>
										<td>
											<? foreach(Router::getLangs() as $lng){ ?>
												<div>
													<label><input type="radio" ui-lang="<?=$lng?>" name="lang"> <?=LanguagesClass::getLang($lng)?></label>
												</div>
											<? } ?>
										</td>
									</tr>

									<tr><td colspan="2" style="height: 10px"></td></tr>

									<tr>
										<td class="taright pr10">Назва:</td>
										<td>
											<input type="text" ui="name" class="k-textbox" style="width: 100%" />
										</td>
									</tr>

									<tr><td colspan="2" style="height: 10px"></td></tr>

									<tr>
										<td class="taright pr10">Посилання:</td>
										<td>
											<input type="text" id="href" class="k-textbox" style="width: 100%" />
										</td>
									</tr>

									<tr><td colspan="2" style="height: 10px"></td></tr>

									<tr>
										<td></td>
										<td>
											<label><input type="checkbox" id="is_public" /> Опублікована</label>
										</td>
									</tr>

									<tr><td colspan="2" style="height: 30px"></td></tr>

									<tr>
										<td></td>
										<td>
											<input type="submit" value="Зберегти" class="k-button" />
										</td>
									</tr>

								</tbody>

							</table>

						</form>
					</td>
					
				</tr>
				
			</tbody>
		</table>
		
	</div>
</div>
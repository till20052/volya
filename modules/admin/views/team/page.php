<div class="header">
	<div>
		<div>
			
			<table width="100%" cellpadding="0" cellspacing="0">
				<td>
					<h1>
						<a href="/admin">Адмін панель</a> / <?=t(TeamAdminController::$modAText)?>
					</h1>
				</td>
			</table>
			
		</div>
	</div>
</div>

<div>
	<div>
		
		<div class="tabbar">
			<ul>
				<li <? if( Router::getController() == "Team" && Router::getMethod() == "execute" ){ ?> class="selected"<? } ?>>
					<a href="/admin/team">Команда</a>
				</li>
				<li <? if( Router::getController() == "Team" && Router::getMethod() == "page" ){ ?> class="selected"<? } ?>>
					<a href="/admin/team/page">Сторінка команди</a>
				</li>
			</ul>
		</div>
		
	</div>
</div>

<div ui-box="team" data-id="<?=$item["id"]?>" class="mt15">
	
	<div class="dtable-cell pl10">
		<div ui-message="error" class="alert alert-error" style="display:none">
			<i class="icon-erroralt"></i>
			<div><?=t("Помилка при збереженні матеріалу")?></div>
		</div>
		<div ui-message="success" class="alert" style="display:none">
			<i class="icon-ok"></i>
			<div><?=t("Матеріал успішно збережено !")?></div>
		</div>
		<form action="/admin/pages/j_save" method="POST">

			<table cellpadding="0" cellspacing="0">

				<tbody>

					<tr>
						<td width="15%" class="taright pr10">Мова:</td>
						<td colspan="2">
							<? foreach(Router::getLangs() as $lng){ ?>
								<label><input type="radio" ui-lang="<?=$lng?>" name="lang"> <?=LanguagesClass::getLang($lng)?></label>
							<? } ?>
						</td>
					</tr>

					<tr><td colspan="3" style="height: 5px"></td></tr>

					<tr>
						<td class="taright pr10">Назва:</td>
						<td colspan="2">
							<input type="text" ui="title" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="3" style="height: 5px"></td></tr>

<!--					<tr>
						<td class="taright pr10">Посилання:</td>
						<td class="pr5">
							<span id="symlink" style="width: 100%"></span>
						</td>
					</tr>-->

<!--					<tr><td colspan="3" style="height: 5px"></td></tr>

					<tr>
						<td></td>
						<td colspan="2">
							<label><input type="checkbox" id="is_public" /> Опублікована</label>
						</td>
					</tr>-->

					<tr><td colspan="3" style="height: 5px"></td></tr>

					<tr>
						<td colspan="3">
							<textarea ui="text" style="width: 100%; height: 300px"></textarea>
						</td>
					</tr>

					<tr><td colspan="3" style="height: 5px"></td></tr>

					<tr>
						<td colspan="3">
							<div class="fright">
								<input type="button" id="submit" value="Зберегти" class="k-button" />
							</div>
							<div class="cboth"></div>
						</td>
					</tr>

				</tbody>
			</table>
		</form>
	</div>
</div>
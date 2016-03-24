<script id="data">(<?=json_encode(array(
	"birthday" => array(
		"day" => $profile["birthday_day"],
		"month" => $profile["birthday_month"],
		"year" => $profile["birthday_year"],
	),
	"rid" => $profile["region_id"],
	"aid" => $profile["area_id"],
	"cid" => $profile["city_id"],
	"education_level" => $profile["education_level"],
	"professional_status" => $profile["professional_status"],
	"employment_scope" => $profile["employment_scope"],
	"docs" => $profile["docs"],
	"employment_scopes" => EmploymentScopesModel::i()->getCompiledList()
))?>);</script>

<!--<div class="header">
	<div>
		<h1><?=t("Редагування профілю")?></h1>
	</div>
</div>-->

<div class="header">
	<div>
		<a href="/profile" id="back"><?=t("Мій профіль")?></a>
	</div>
	<div>
		<h1><?=t("Редагування профілю")?></h1>
	</div>
</div>

<div class="section">
	<div>	
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>	
					<td>
						
						<div>
							<div class="tabbar">
								<ul>
									<li class="selected">
										<a href="javascript:void(0);" data-uiBox="basic"><?=t("Основне")?></a>
									</li>
									<li>
										<a href="javascript:void(0);" data-uiBox="education_jobs"><?=t("Освіта/Проф. діяльність")?></a>
									</li>
									<li>
										<a href="javascript:void(0);" data-uiBox="contacts"><?=t("Контакти")?></a>
									</li>
									<li>
										<a href="javascript:void(0);" data-uiBox="scans"><?=t("Сканкопії")?></a>
									</li>
									<li>
										<a href="javascript:void(0);" data-uiBox="settings"><?=t("Налаштування")?></a>
									</li>
								</ul>
							</div>
						</div>
						
						<div class="mt30">
							<form id="profile" data-uid="<?=$profile["id"]?>" action="/profile/edit/j_save" method="post">
			
								<? $leftColumnWidth = "25%" ?>

								<? include "edit/basic.php" ?>
								<? include "edit/education_jobs.php" ?>
								<? include "edit/contacts.php" ?>
								<? include "edit/scans.php" ?>
								<? include "edit/settings.php" ?>
								
								<div class="mt30 pt15" style="border-top: 1px solid gray">
									<div data-uiBox="success" class="p5 dnone" style="border: 1px solid yellowgreen; color: green">
										<i class="icon-ok"></i>
										<span><?=t("Дані успішно збережені")?></span>
									</div>
									<div class="mt15">
										<table width="100%" cellspacing="0" cellpadding="0">
											<tbody>
												<tr>
													<td width="<?=$leftColumnWidth?>"></td>
													<td>
														<input type="submit" value="<?=t("Зберегти")?>" class="k-button" />
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>

							</form>
						</div>
					</td>
					
				</tr>
			</tbody>
		</table>
		
	</div>
</div>

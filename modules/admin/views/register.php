<div class="header">
	<div>
		<h1>
			<? if(Router::getMethod() == "settings"){ ?>
				<a href="/admin"><?=t("Адмін панель")?></a> / <a href="/admin/register"><?=t(RegisterAdminController::$modAText)?></a> / <?=t("Налаштування")?>
			<? } else { ?>
				<a href="/admin"><?=t("Адмін панель")?></a> / <?=t(RegisterAdminController::$modAText)?>
			<? } ?>
		</h1>
	</div>
</div>

<div class="section">
	<div>
		
		<div class="mb15">
			
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						
						<? if(Router::getMethod() != "settings"){ ?>
							<td>
								<div class="tabbar">
									<ul>
										<li<? if(Router::getMethod() == "members"){ ?> class="selected"<? } ?>>
											<a href="/admin/register/members"><?=t("Єдиний реєстр членів")?></a>
										</li>
										<li<? if(Router::getMethod() == "cells"){ ?> class="selected"<? } ?>>
											<a href="/admin/register/cells"><?=t("Єдиний реєстр осередків")?></a>
										</li>
									</ul>
								</div>
							</td>

							<td class="taright">
								<a href="/admin/register/settings" class="icon">
									<span><?=t("Налаштування")?></span>
									<i class="icon-squaresettings fs20"></i>
								</a>
							</td>
						<? } ?>
						
					</tr>
				</tbody>
			</table>
			
			
			
		</div>
		
		<? include "register/".Router::getMethod().".php" ?>
		
	</div>
</div>

<div class="header">
	<div>
		<h1>
			<a href="/admin"><?=t("Адмін панель")?></a> / <?=t(ElectionAdminController::$modAText)?>
		</h1>
	</div>
</div>

<div class="section">
	<div>
		
		<div class="mb15">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						
						<td>
							<div class="tabbar">
								<ul>
									<li<? if(Router::getMethod() == "candidates"){ ?> class="selected"<? } ?>>
										<a href="/admin/election/candidates"><?=t("Кандидати")?></a>
									</li>
									<li<? if(Router::getMethod() == "exitpollsResults"){ ?> class="selected"<? } ?>>
										<a href="/admin/election/exitpolls_results"><?=t("Результати екзит-полів")?></a>
									</li>
								</ul>
							</div>
						</td>
						
					</tr>
				</tbody>
			</table>
		</div>
		
		<? include "election/".Router::getMethod().".php" ?>
		
	</div>
</div>
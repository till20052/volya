<div ui-window="admin.cells.viewer" style="width: 400px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Переглядач")?></h2>
	</div>
	
	<div class="mt10">
		
		<div>	
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>	
						<td style="width: 100%">
							<div>
								<div data-uiTabStrip="viewer">
									<ul>
										<li class="k-state-active"><?=t("Основне")?></li>
										<li><?=t("Учасники")?></li>
										<li><?=t("Скани")?></li>
										<li><?=t("Перевірка")?></li>
									</ul>
									
									<div><? include "viewer/basic.php" ?></div>
									<div><? include "viewer/users.php" ?></div>
									<div><? include "viewer/scans.php" ?></div>
									<div><? include "viewer/verification.php" ?></div>
								</div>
							</div>
						</td>

					</tr>
				</tbody>
			</table>

		</div>
		
	</div>
	
</div>
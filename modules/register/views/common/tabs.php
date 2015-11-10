<div class="mb15">

	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>

			<td>
				<div class="tabbar">
					<ul>
						<? if(Router::getController() == "Admin"){ ?>
							<li<? if(Router::getMethod() == "krkManager"){ ?> class="selected"<? } ?>>
								<a href="/register/admin/krk_manager"><?=t("Менеджер КРК")?></a>
							</li>
						<? } ?>
					</ul>
				</div>
			</td>

		</tr>
		</tbody>
	</table>

</div>
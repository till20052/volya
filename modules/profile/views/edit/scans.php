<div data-uiBox="scans" class="dnone">
	
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr style="height: 40px;">
				<td colspan="4">
					<input type="checkbox" <? if($profile["was_allowed_to_use_pd"]){ echo 'disabled="" checked=""'; } ?> id="allowToUsePd" class="k-checkbox" /> <?=t("Я дозволяю використовувати мої данні")?>
				</td>
			</tr>
			
			<tr><td colspan="4" style="height: 15px;"></td></tr>
			
			<tr<? if(!$profile["was_allowed_to_use_pd"]){ ?> class="dnone"<? } ?> ui="previews">
				<td>
					<div id="uploadPassportPage1" class="scanPreview">
						<div class="scanMenu dnone">
							<div>
								<?=t("Скан першої сторінки паспорту")?>
							</div>
							<div class="delete">
								<a class="icon">
									<i class="icon-trash"></i>
									<span><?=t("Видалити")?></span>
								</a>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div id="uploadPassportPage2" class="scanPreview">
						<div class="scanMenu dnone">
							<div>
								<?=t("Скан другої сторінки паспорту")?>
							</div>
							<div class="delete">
								<a class="icon">
									<i class="icon-trash"></i>
									<span><?=t("Видалити")?></span>
								</a>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div id="uploadPassportPage11" class="scanPreview">
						<div class="scanMenu dnone">
							<div>
								<?=t("Скан одинадцятої сторінки паспорту")?>
							</div>
							<div class="delete">
								<a class="icon">
									<i class="icon-trash"></i>
									<span><?=t("Видалити")?></span>
								</a>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr<? if(!$profile["was_allowed_to_use_pd"]){ ?> class="dnone"<? } ?> ui="previews">
				<td>
					<div id="uploadTin" class="scanPreview">
						<div class="scanMenu dnone">
							<div>
								<?=t("Скан ІПН")?>
							</div>
							<div class="delete">
								<a class="icon">
									<i class="icon-trash"></i>
									<span><?=t("Видалити")?></span>
								</a>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div id="uploadApplicationForMembership" class="scanPreview">
						<div class="scanMenu dnone">
							<div>
								<?=t("Скан заяви про набуття членства")?>
							</div>
							<div class="delete">
								<a class="icon">
									<i class="icon-trash"></i>
									<span><?=t("Видалити")?></span>
								</a>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div id="uploadLustrationDeclaration" class="scanPreview">
						<div class="scanMenu dnone">
							<div>
								<?=t("Скан люстраційної декларації")?>
							</div>
							<div class="delete">
								<a class="icon">
									<i class="icon-trash"></i>
									<span><?=t("Видалити")?></span>
								</a>
							</div>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	
</div>
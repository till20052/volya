<div data-uiBox="scans">
	
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td colspan="4">
					<div class="allow">
						<div class="icon">
							<i class="icon-ok-circle fs16" style="color: green"></i>
							<span><?=t("Користувач дозволив використовувати свої персональні данні")?></span>
						</div>
					</div>
					<div class="disallow">
						<div class="icon">
							<i class="icon-remove-circle fs16" style="color: red"></i>
							<span><?=t("Користувач не дозволив використовувати свої персональні данні")?></span>
						</div>
					</div>
				</td>
			</tr>
			
			<tr><td colspan="4" style="height: 15px;"></td></tr>
			
			<tr class="scanPreviewTr">
				<td style="padding-right: 6px;">
					<div class="scanName"><?=t("Скан першої сторінкі паспорту")?></div>
					<div id="PassportPage1" class="scanPreview"></div>
					<div class="scansZoom">
						<i class="icon-mergeshapes"></i>
					</div>
				</td>
				<td style="padding: 0 3px;">
					<div class="scanName"><?=t("Скан другої сторінкі паспорту")?></div>
					<div id="PassportPage2" class="scanPreview"></div>
					<div class="scansZoom">
						<i class="icon-mergeshapes"></i>
					</div>
				</td>
				<td style="padding-left: 6px;">
					<div class="scanName"><?=t("Скан одинадцятої сторінкі паспорту")?></div>
					<div id="PassportPage11" class="scanPreview"></div>
					<div class="scansZoom">
						<i class="icon-mergeshapes"></i>
					</div>
				</td>
			</tr>
			<tr class="scanPreviewTr pt10">
				<td style="padding-right: 6px;">
					<div class="scanName"><?=t("Скан ІПН")?></div>
					<div id="Tin" class="scanPreview"></div>
					<div class="scansZoom">
						<i class="icon-mergeshapes"></i>
					</div>
				</td>
				<td style="padding: 0 3px;">
					<div class="scanName"><?=t("Скан заяви про набуття членства")?></div>
					<div id="ApplicationForMembership" class="scanPreview"></div>
					<div class="scansZoom">
						<i class="icon-mergeshapes"></i>
					</div>
				</td>
				<td style="padding-left: 6px;">
					<div class="scanName"><?=t("Скан люстраційної декларації")?></div>
					<div id="LustrationDeclaration" class="scanPreview"></div>
					<div class="scansZoom">
						<i class="icon-mergeshapes"></i>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	
</div>
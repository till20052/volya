<div ui-window="admin.election.candidates.export_form" style="width: 400px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Експорт")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					<td width="25%" align="right" class="pr5">
						<div><?=t("З")?></div>
					</td>
					<td width="50%">
						<input type="text" data-uiDatePicker="from" style="width: 100%" />
					</td>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<td colspan="3" style="height: 5px"></td>
				</tr>
				
				<tr>
					<td width="25%" align="right" class="pr5">
						<div><?=t("По")?></div>
					</td>
					<td width="50%">
						<input type="text" data-uiDatePicker="to" style="width: 100%" />
					</td>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<td colspan="3" style="height: 10px"></td>
				</tr>
				
				<tr>
					<td colspan="3" align="center">
						<a data-action="export" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Експортувати")?></a>
					</td>
				</tr>
				
			</tbody>
		</table>
		
	</div>
	
</div>
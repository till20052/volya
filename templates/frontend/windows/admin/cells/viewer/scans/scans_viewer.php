<div ui-window="admin.cells.scans_viewer" style="width: 700px; margin-top: 0">
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Перегляд сканів")?></h2>
	</div>
	
	<div class="mt10">
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					<td width="5%" class="taright pr5">
						<i class="icon-chevron-left fs25" id="prevImage"></i>
					</td>
					<td>
						<div class="dnone" id="data"></div>
						<img id="image" style="width: 100%;" />
					</td>
					<td width="5%" class="pl5">
						<i class="icon-chevron-right fs25" id="nextImage"></i>
					</td>
				</tr>
				
			</tbody>
		</table>

	</div>
</div>
<div ui-window="admin.election.exitpolls_results.party_form" style="width: 400px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Партія")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<div>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="30%"><?=t("Найменування")?>:</td>
						<td>
							<input type="text" id="name" class="textbox" style="width: 100%" />
						</td>
					</tr>
					
					<tr>
						<td colspan="2" style="height: 15px"></td>
					</tr>
					
					<tr>
						<td colspan="2" class="tacenter">
							<a href="javascript:void(0);" data-action="save" class="v-button v-button-blue mr5"><?=t("Зберегти")?></a><!--
							--><a href="javascript:void(0);" data-action="cancel" class="v-button"><?=t("Відміна")?></a>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
	</div>
	
</div>
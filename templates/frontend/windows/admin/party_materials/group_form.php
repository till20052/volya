<div ui-window="admin.party_materials.group_form" style="width: 500px">

	<div class="fright">
		<a class="closeButton"></a>
	</div>

	<div>
		<h2><?=t("Група")?></h2>
	</div>

	<div class="mt10">
		<form action="/admin/party_materials/j_group_save" method="post">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>

				<tr>
					<td width="25%" class="taright pr15"><?=t("Назва")?></td>
					<td>
						<input id="name" type="text" class="textbox" style="width: 100%" />
					</td>
				</tr>

				<tr><td colspan="2" style="height: 15px"></td></tr>

				<tr>
					<td colspan="2" class="tacenter">
						<input type="submit" class="dnone">
						<a id="save" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Зберегти")?></a><!--
						--><a id="cancel" href="javascript:void(0);" class="v-button ml5"><?=t("Відміна")?></a>
					</td>
				</tr>

				</tbody>
			</table>
		</form>
	</div>

</div>
<div ui-window="admin.agitations.form" style="width: 400px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Агітаційний матеріал")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<form data-inElection="<?=($filter["type"] == "election" ? 1 : 0)?>" action="/admin/agitations/j_save" method="post">
			
			<div>
				<div data-uiUploader="preview" class="avatar avatar-8x">
					<div class="avatar avatar-8x">
						<input type="file" name="file" title="<?=t("Завантажити превью")?>" />
						<i class="icon-uploadalt"><?=t("Завантажити")?><br /><?=t("фото")?></i>
					</div>
					<i class="icon-images-gallery"></i>
				</div>
			</div>
			
			<div class="mt15 tacenter">
				<div data-uiUploader="file">
					<div data-uiBox="uploader">
						<a href="javascript:void(0);" class="v-button v-button-blue">
							<input type="file" name="file" />
							<?=t("Завантажити файл")?>
						</a>
					</div>
					<div data-uiBox="success">
						<div>
							<span></span>
							<a href="javascript:void(0);" data-action="delete" class="icon"><i class="icon-remove"></i></a>
						</div>
					</div>
				</div>
			</div>

			<div class="mt15">
				<div><?=t("Назва")?></div>
				<div>
					<input type="text" id="name" class="textbox" style="width: 100%" />
				</div>
			</div>
			
			<div class="mt15">
				<div><?=t("Категорії")?></div>
				<div>
					<table width="100%" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								
								<td class="pr5">
									<select data-ui="categories" style="width: 100%">
										<script>(<?=json_encode($agitationCategories)?>);</script>
									</select>
								</td>
								
								<td width="20px">
									<a data-action="manage_categories" href="javascript:void(0);" class="v-button" style="width: 100%">...</a>
								</td>
								
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="mt15 tacenter">
				<a data-action="submit" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Зберегти")?></a><!--
				--><a data-action="cancel" href="javascript:void(0);" class="v-button ml5"><?=t("Відміна")?></a>
			</div>
			
		</form>
		
	</div>
	
</div>
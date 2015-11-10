<div data-uiBox="documents">
	
	<div class="header">
		<table width="100%" cellspacing="0" cellpadding="0">
			<td>
				<h3><?=t("Документи")?></h3>
			</td>
			<? if(CellsModel::i()->isMember(UserClass::i()->getId())){ ?>
				<td class="taright">
					<input type="button" id="add_document" value="<?=t("Додати")?>" class="button" />
				</td>
			<? } ?>
		</table>
	</div>
	
	<div class="section">
		
		<div>
			<table data-ui="list" width="100%" cellspacing="0" cellpadding="0">
				<? if(CellsModel::i()->isMember(UserClass::i()->getId())){ ?>
					<script type="text/x-kendo-template" id="row_template">
						<tr data-id="#=id#">
							<td>
								<a href="/s/storage/#=hash#" target="_blank" class="icon">
									<i class="icon-document fs20"></i>
									<span>#=name#</span>
								</a>
							</td>
							<td class="taright">
								<a data-uiAction="remove" href="javascript:void(0);" class="icon">
									<i class="icon-remove" style="padding: 0"></i>
								</a>
							</td>
						</tr>
					</script>
					<script type="text/x-kendo-template" id="empty">
						<tr data-id="0">
							<td>
								<div><?=t("Немає документів")?></div>
							</td>
						</tr>
					</script>
				<? } ?>
				<tbody>
					<? if(count($cell["documents"])){ ?>
						<? foreach($cell["documents"] as $__item){ ?>
							<tr data-id="<?=$__item["id"]?>">
								<td>
									<a href="/s/storage/<?=$__item["hash"]?>" target="_blank" class="icon">
										<i class="icon-document fs20"></i>
										<span><?=$__item["name"]?></span>
									</a>
								</td>
								<? if(CellsModel::i()->isMember(UserClass::i()->getId())){ ?>
									<td class="taright">
										<a data-uiAction="remove" href="javascript:void(0);" class="icon">
											<i class="icon-remove" style="padding: 0"></i>
										</a>
									</td>
								<? } ?>
							</tr>
						<? } ?>
					<? } else { ?>
						<tr data-id="0">
							<td>
								<div><?=t("Немає документів")?></div>
							</td>
						</tr>
					<? } ?>
				</tbody>
			</table>
		</div>
		
	</div>
	
</div>
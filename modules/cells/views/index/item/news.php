<div data-uiBox="news">
	
	<div class="header">
		<table width="100%" cellspacing="0" cellpadding="0">
			<td>
				<h3><?=t("Новини")?></h3>
			</td>
			<? if(CellsModel::i()->isMember(UserClass::i()->getId())){ ?>
				<td class="taright">
					<input type="button" id="add_new" value="<?=t("Додати")?>" class="button" />
				</td>
			<? } ?>
		</table>
	</div>
	
	<div class="section">
		<div data-uiBox="list">
			<? if(CellsModel::i()->isMember(UserClass::i()->getId())){ ?>
				<script type="text/x-kendo-template" id="row_template">
					<div data-id="#=id#"# if(is_public != 1){ # class="invisible"# } #>
						<div class="fright">
							<a data-uiAction="remove" href="javascript:void(0)" class="icon">
								<i class="icon-remove" style="padding: 0"></i>
							</a>
						</div>
						<div>
							<div>
								<div class='preview'# if(image != ""){ # style="background-image: url('/s/img/thumb/ad/#=image#')"# } #></div>
							</div>
							<div class="p15">
								<a href="javascript:void(0);">#=title.<?=Router::getLang()?>#</a>
							</div>
						</div>
					</div>
				</script>
				<script type="text/x-kendo-template" id="empty">
					<div data-uiBox="empty">
						<div><?=t("Немає записів")?></div>
					</div>
				</script>
			<? } ?>
			<? if(count($cell["news"]) > 0){ ?>
				<? foreach($cell["news"] as $__item){ ?>
					<div data-id="<?=$__item["id"]?>"<? if( ! $__item["is_public"]){ ?> class="invisible"<? } ?>>
						<div class="fright">
							<a data-uiAction="remove" href="javascript:void(0)" class="icon">
								<i class="icon-remove" style="padding: 0"></i>
							</a>
						</div>
						<div>
							<div>
								<div class='preview'<? if( ! empty($__item["image"])){ ?> style="background-image: url('/s/img/thumb/ad/<?=$__item["image"]?>')"<? } ?>></div>
							</div>
							<div class="p15">
								<a href="#"><?=$__item["title"][Router::getLang()]?></a>
							</div>
						</div>
					</div>
				<? } ?>
			<? } else { ?>
				<div data-uiBox="empty">
					<div><?=t("Немає записів")?></div>
				</div>
			<? } ?>
		</div>
	</div>
	
</div>
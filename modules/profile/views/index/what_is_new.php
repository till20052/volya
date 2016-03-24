<div data-uiBox="what_is_new">
	
	<div class="header">
		<h3><?=t("Що нового?")?></h3>
	</div>
	
	<div class="section">
		<? if($profile["id"] == UserClass::i()->getId()){ ?>
			<div data-uiBox="toolbar">
				<a href="javascript:void(0);" class="button" data-bml="220" data-type="blog">
					<img src="/img/frontend/profile/blog_add.png" alt="<?=t("Запис в блог")?>" />
					<div><?=t("Запис в блог")?></div>
				</a>
				<div></div>
				<a href="javascript:void(0);" class="button" data-bml="405" data-type="news">
					<img src="/img/frontend/profile/news_add.png" alt="<?=t("В новину")?>" />
					<div><?=t("В новину")?></div>
				</a>
			</div>

			<div data-uiBox="form">
				<span class="bubble"></span>
				<div data-uiFrame="first">
					<form action="/profile/j_create_material" method="post">
						<div>
							<input type="text" id="title" placeholder="<?=t("Назва новини")?>" class="textbox" />
						</div>

						<div class="mt15" style="line-height: 0;">
							<textarea data-ui="text" placeholder="<?=t("Зміст новини")?>" class="textbox" style="min-height: 200px; resize: vertical"></textarea>
						</div>

						<div class="mt15">
							<input type="submit" value="<?=t("Додати")?>" class="button x2" />
						</div>
					</form>
				</div>
				<div data-uiFrame="after_send">
					<div><?=t("Ваш матеріал буде доступний для перегляду іншим учасникам після того, як модератор перевірить його зміст")?></div>
				</div>
			</div>
		<? } ?>
		
		<div data-uiBox="list">
			<? if($profile["id"] == UserClass::i()->getId()){ ?>
				<script type="text/x-kendo-template">
					<div# if(is_public != 1){ # class="invisible"# } #>
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
			<? } ?>
			<? if(count($profile["news"]) > 0){ ?>
				<? foreach($profile["news"] as $__item){ ?>
					<div<? if( ! $__item["is_public"]){ ?> class="invisible"<? } ?>>
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
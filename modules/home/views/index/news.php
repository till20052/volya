<div data-uiBox="news">
	<div>

		<div>
			<a href="/election">
				<h2><?=t("Новини")?></h2>
			</a>
		</div>

		<div class="mt15">
			<table class="news" cellpadding="0" cellspacing="0">
				<tbody>

				<? $__counter = 0; ?>
				<? $__rowsCounter = 0; ?>
				<? $__columnsCount = 4; ?>

				<? foreach(array_splice($news, 0, 8) as $__item){ ?>

					<? if($__counter == 0){ ?>
						<tr>
					<? } ?>

					<? $__symlink = "/news/".$__item["id"] ?>

					<td>

						<? if($__rowsCounter == 0) { ?>

							<div>
								<a href="<?=$__symlink?>">
									<div class="preview"<? if(count($__item["images"]) > 0){ ?> style="background-image:url('/s/img/thumb/ah/<?=$__item["images"][0]?>')"<? } ?>></div>
								</a>
							</div>

							<div>
								<a href="<?=$__symlink?>" class="title"><?=$__item["title"][Router::getLang()]?></a>
							</div>

							<div>
								<span class="datetime"><?=$application->intlDateFormatter->format(strtotime($__item["created_at"]))?></span>
							</div>

						<? } else { ?>

							<div class="mt30" style="border-top: 2px solid #0181C5">
								<div>
									<a href="<?=$__symlink?>" class="title"><?=$__item["title"][Router::getLang()]?></a>
								</div>

								<div>
									<span class="datetime"><?=$application->intlDateFormatter->format(strtotime($__item["created_at"]))?></span>
								</div>
							</div>

						<? } ?>

					</td>

					<? if($__counter < $__columnsCount - 1){ ?>
						<td>&nbsp;</td>
					<? } ?>

					<? if($__counter == $__columnsCount - 1){ ?>
						</tr>
						<? $__rowsCounter++ ?>
						<? $__counter = 0; ?>
					<? } else { ?>
						<? $__counter++ ?>
					<? } ?>

				<? } ?>

				<? if($__counter != 0 && $__counter != $__columnsCount){ ?>
					</tr>
				<? } ?>

				</tbody>
			</table>
		</div>

		<div class="mt30">
			<table width="100%" cellspacing="0" cellpadding="0">
				<td width="49%" class="pr15">
					<hr style='border: 0; border-top: 1px solid #DBD8D0' />
				</td>
				<td>
					<a href="/news" class="v-button" style="white-space: nowrap">
						<span><?=t("Всі новини")?></span>
					</a>
				</td>
				<td width="49%" class="pl15">
					<hr style='border: 0; border-top: 1px solid #DBD8D0' />
				</td>
			</table>
		</div>
	</div>
</div>

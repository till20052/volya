<div class="header">
	<div>
		<h1 class="ttuppercase"><?=$indexProjectsController->item["title"][Router::getLang()]?></h1>
	</div>
</div>

<div>
	<div>
		<div>
			<?=$indexProjectsController->item["text"][Router::getLang()]?>
		</div>
		<div class="cboth"></div>
	</div>
	
	<div>
		<h1 class="ttuppercase"><?=t("Новини проекту")?></h1>
	</div>
</div>

<div class="section mt15">
	<div>

		<? if(count($indexProjectsController->newsList) > 0){ ?>
		<table class="list">
			<tbody>

				<? $__counter = 0; ?>
				<? $__rowsCounter = 0; ?>
				<? $__columnsCount = 4; ?>

				<? foreach($indexProjectsController->newsList as $__item){ ?>

					<? if($__counter == 0){ ?>
						<tr>
					<? } ?>

					<td>
						<div>

							<div>
								<div class="preview"<? if($__item["image"] != ""){ ?> style="background-image:url('/s/img/thumb/ah/<?=$__item["image"]?>')"<? } ?>></div>
							</div>

							<div>
								<a href="/news/projects/<?=$__item["id"]?>" class="fs16"><?=$__item["title"][Router::getLang()]?></a>
							</div>

							<div>
								<span><?=$application->intlDateFormatter->format(strtotime($__item["created_at"]))?></span>
							</div>

						</div>
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
					<? for($i = $__counter; $i < $__columnsCount; $i++){ ?>
						<td>&nbsp;</td>
						<? if($i < $__columnsCount - 1){ ?>
							<td>&nbsp;</td>
						<? } ?>
					<? } ?>
					</tr>
				<? } ?>

			</tbody>
		</table>
	<? } else { ?>
		<div data-uiBox="empty_list"><?=t("Ще немає новин")?></div>
	<? } ?>

	</div>

	<? if($indexProjectsController->pager->getPages() > 1){ ?>
	<div style="margin-top:50px">

		<div class="paginator">

			<? $__current = $indexProjectsController->pager->getPage() ?>
			<? $__count = $indexProjectsController->pager->getPages() ?>

			<div>
				<a href="<? if($__current > 1){ ?>?page=<?=($__current - 1)?><? } else { ?>javascript:void(0)<? } ?>"
				   class="arrow<? if( ! ($__current > 1)){ ?> disabled<? } ?>">
					<i class="icon-chevron-left"></i>
				</a>
			</div>

			<div>
				<ul>
					<? $__length = $__count > 5 ? 5 : $__count ?>
					<? $__start = $__current - round($__length / 2) ?>	
					<? $__end = $__current + intval($__length / 2); ?>

					<? if($__start < 0){ ?>
						<? $__end += abs($__start) ?>
						<? $__start = 0 ?>
					<? } ?>

					<? if($__end > $__count){ ?>
						<? $__start -= ($__end - $__count) ?>
						<? $__end = $__count ?>
					<? } ?>

					<? if($__start >= 1){ ?>
						<li>
							<a href="?page=1">1</a>
						</li>
						<? if($__start > 1){ ?>
							<li>...</li>
						<? } ?>
					<? } ?>

					<? for($__i = $__start; $__i < $__end; $__i++){ ?>
						<li>
							<a href="?page=<?=($__i + 1)?>"<? if($__i + 1 == $__current){ ?> class="current"<? } ?>><?=($__i + 1)?></a>
						</li>
					<? } ?>

					<? if($__end <= $__count - 1){ ?>
						<? if($__end < $__count - 1){ ?>
							<li>...</li>
						<? } ?>
						<li>
							<a href="?page=<?=$__count?>"><?=$__count?></a>
						</li>
					<? } ?>
				</ul>
			</div>

			<div>
				<a href="<? if($__current < $__count){ ?>?page=<?=($__current + 1)?><? } else { ?>javascript:void(0)<? } ?>"
				   class="arrow<? if( ! ($__current < $__count)){ ?> disabled<? } ?>">
					<i class="icon-chevron-right"></i>
				</a>
			</div>

		</div>

	</div>
	<? } ?>

</div>
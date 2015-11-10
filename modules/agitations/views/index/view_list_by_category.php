<div class="header">
	<div>
		<div>
			
			<table width="100%" cellpadding="0" cellspacing="0">
				<td>
					<h1 class="ttuppercase"><?=t("Агітація")?></h1>
				</td>
			</table>
			
		</div>
	</div>
</div>

<div class="mb30">
	<div>
		<div>
			
			<div class="tabbar">
				<ul>
					<? foreach($indexNewsController->categories as $__category){ ?><!--
						--><li<? if($indexNewsController->category["id"] == $__category["id"]){ ?> class="selected"<? } ?>>
							<a href="/agitations/<?=$__category["symlink"]?>"><?=$__category["name"][Router::getLang()]?></a>
						</li><!--
					--><? } ?>
				</ul>
			</div>
			
		</div>
	</div>
</div>

<div>
	<div>
		
		<div>
		
			<table width="100%">
				<tbody>
					
					<? $__counter = 0; ?>
					<? $__rowsCounter = 0; ?>
					<? $__columnsCount = 4; ?>
					
					<? foreach($indexNewsController->list as $__item){ ?>
						
						<? if($__counter == 0){ ?>
							<tr>
						<? } ?>
						<td width="25%"<? if($__rowsCounter > 0){ ?> class="pt30"<? } ?>>
							<div style="border: 1px solid #aaa">
								<div>
									<div style="background: url('/s/img/thumb/an/<?=$__item["image"]?>') no-repeat center; background-size: contain; height:230px;"></div>
								</div>
								
								<div style="padding: 5px">
									<div class="fleft">
										<div>
											<?=$__item["name"][Router::getLang()]?>
										</div>
										<div>
											<span class="description"><?=$__item["description"][Router::getLang()]?></span>
										</div>
										<div>
											<span class="datetime" style="color: gray"><?=$application->intlDateFormatter->format(strtotime($__item["created_at"]))?></span>
										</div>
									</div>

									<div class="fright" style="width: 35px">
										<a class="icon fs20" href="/agitations/download_file/<?=$__item["id"]?>"><i class="icon-download-alt"></i></a>
									</div>
									<div class="cboth"></div>
								</div>
							</div>
						</td>
						
						<? if($__counter < $__columnsCount - 1){ ?>
							<td>&nbsp;</td>
						<? } ?>
							
						<? if(($__counter < $__columnsCount - 1) && ($__counter == count($indexNewsController->list) - 1)){ ?>
							<? for($i = 0; $i < $__columnsCount - count($indexNewsController->list); $i++) {?>
								<td width="25%"></td>
								<td>&nbsp;</td>
							<? } ?>
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
		
		<? if($indexNewsController->pager->getPages() > 1){ ?>
		<div style="margin-top:50px">
			
			<div class="paginator">

				<? $__current = $indexNewsController->pager->getPage() ?>
				<? $__count = $indexNewsController->pager->getPages() ?>

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
</div>
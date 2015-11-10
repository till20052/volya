<? include "common/header.php" ?>

<div class="section mt30">
	
	<div>
		<h1 class="fwbold"><?=t("Агітація")?></h1>
	</div>
	
	<? $GW = [300, 330] ?>
	
	<div class="mt5">
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					
					<td valign="top" class="pr30">
						<div>
							<h3>Завантажте та використовуйте ці матеріали для самостійної агітації за партію &laquo;ВОЛЯ&raquo; та її кандидатів на парламенських виборах.</h3>
						</div>
						
						<div data-uiGrid="images" class="mt15">
							<? foreach($list as $__item){ ?>
								<div>
									<div>
										<div class="preview"<? if($__item["image"] != ""){ ?> style="background-image: url('/s/img/thumb/200x/<?=$__item["image"]?>')"<? } ?>></div>
									</div>
									<div class="mt15 pl10">
										<a href="/s/storage/<?=$__item["file"]?>" target="_blank" class="icon">
											<i class="icon-download-alt"></i>
											<span><?=t("Завантажити")?></span>
										</a>
									</div>
								</div>
							<? } ?>
							<div></div>
						</div>
					</td>
					
					<td valign="top" style="width: <?=$GW[0]?>px">
						<div class="p15" style="background-color: white">
							
							<div>
								<ul data-uiSwitcher="categories">
									<li<? if( ! isset($filter["category"])){ ?> class="selected"<? } ?>>
										<a href="/party/agitation"><?=t("Всі матеріали")?></a>
									</li>
									<? foreach($categories as $__category){ ?>
										<li<? if(isset($filter["category"]) && $filter["category"] == $__category["id"]){ ?> class="selected"<? } ?>>
											<a href="/party/agitation?category=<?=$__category["id"]?>"><?=$__category["name"]?></a>
										</li>
									<? } ?>
								</ul>
							</div>
							
						</div>
					</td>
					
				</tr>
			</tbody>
		</table>
	</div>
	
	<? if($pager->getPages() > 1){ ?>
		<div class="mt30">

			<div class="paginator">

				<? $__current = $pager->getPage() ?>
				<? $__count = $pager->getPages() ?>

				<? if( ! isset($__query["page"])){ ?><? $__query["page"] = "" ?><? } ?>

				<div>
					<? $__query["page"] = $__current - 1 ?>
					<a href="<? if($__current > 1){ ?>?<?=http_build_query($__query)?><? } else { ?>javascript:void(0)<? } ?>"
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
								<? $__query["page"] = 1 ?>
								<a href="?<?=http_build_query($__query)?>">1</a>
							</li>
							<? if($__start > 1){ ?>
								<li>...</li>
							<? } ?>
						<? } ?>

						<? for($__i = $__start; $__i < $__end; $__i++){ ?>
							<li>
								<? $__query["page"] = $__i + 1 ?>
								<a href="?<?=http_build_query($__query)?>"<? if($__i + 1 == $__current){ ?> class="current"<? } ?>><?=($__i + 1)?></a>
							</li>
						<? } ?>

						<? if($__end <= $__count - 1){ ?>
							<? if($__end < $__count - 1){ ?>
								<li>...</li>
							<? } ?>
							<li>
								<? $__query["page"] = $__count ?>
								<a href="?<?=http_build_query($__query)?>"><?=$__count?></a>
							</li>
						<? } ?>
					</ul>
				</div>

				<div>
					<? $__query["page"] = $__current + 1 ?>
					<a href="<? if($__current < $__count){ ?>?<?=http_build_query($__query)?><? } else { ?>javascript:void(0)<? } ?>"
					   class="arrow<? if( ! ($__current < $__count)){ ?> disabled<? } ?>">
						<i class="icon-chevron-right"></i>
					</a>
				</div>

			</div>

		</div>
	<? } ?>
	
</div>
<div class="header">
	<div>&nbsp;</div>
</div>

<? $GW = [300, 330] ?>
<? parse_str(parse_url(Uri::getUrn(), PHP_URL_QUERY), $__query) ?>

<div class="section mt30">
	<div>
		<h3 class="fwbold fs25" style="color: #858383"><?=t("Новини")?></h3>
	</div>
	
	<div class="mt30">
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					
					<td valign="top" class="pr30">
						
						<table width="100%" cellspacing="0" cellpadding="0">
							<tbody>
								
								<? $application->intlDateFormatter->setPattern("d MMMM") ?>
								<? $__tokens = explode(" ", isset($filter["q"]) ? $filter["q"] : "") ?>
								
								<? foreach($list as $__i => $__item){ ?>
									<? foreach($__tokens as $__token){ ?>
										<? if(empty($__token)){ continue; } ?>
										<? $__item["title"] = str_ireplace($__token, "<span style='color:red'>".$__token."</span>", $__item["title"]) ?>
										<? $__item["announcement"] = str_ireplace($__token, "<span style='color:red'>".$__token."</span>", $__item["announcement"]) ?>
									<? } ?>
									<tr>
										<td valign="top" style="width: 150px">
											<div data-href="/news/<?=$__item["id"]?>" class="preview s150x120"<? if(count($__item["images"]) > 0){ ?> style="background-image: url('/s/img/thumb/150x100/<?=$__item["images"][0]?>')"<? } ?>></div>
										</td>
										<td valign="top" class="pl25">
											<div style="color: #666"><?=$application->intlDateFormatter->format(strtotime($__item["created_at"]))?></div>
											<div class="mt10">
												<a href="/news/<?=$__item["id"]?>" class="fs16"><?=$__item["title"]?></a>
											</div>
											<div class="mt10" style="color: #333">
												<span><?=$__item["announcement"]?></span>
											</div>
										</td>
									</tr>

									<? if(count($list) > $__i + 1){ ?>
										<tr>
											<td colspan="2" style="height: 30px">&nbsp;</td>
										</tr>
									<? } ?>
								<? } ?>
								
							</tbody>
						</table>
						
					</td>
					
					<td valign="top" width="<?=$GW[0]?>px">


						<div class="p15" style="background-color: white">
							<div>
								<h3>Пошук</h3>
								<div class="mt15">
									<input<? if(isset($filter["q"])){ ?> value="<?=$filter["q"]?>"<? } ?> id="query" type="text" class="textbox" style="width: 100%" />
								</div>
								<div class="mt15 tacenter">
									<a data-action="search" href="javascript:void(0);" class="v-button v-button-blue"><?=t('Знайти')?></a>
								</div>
							</div>
						</div>

						<div class="mt15 p15" style="background-color: white">
							
							<div>
								<ul data-uiSwitcher="categories">
									<li<? if( ! isset($filter["category"])){ ?> class="selected"<? } ?>>
										<a href="/news"><?=t("Усі новини")?></a>
									</li>
									<? foreach($categories as $__category){ ?>
										<li<? if(isset($filter["category"]) && $filter["category"] == $__category["id"]){ ?> class="selected"<? } ?>>
											<a href="?category=<?=(in_array($__category["symlink"], ["by_regions"]) ? $__category["symlink"] : $__category["id"])?>"><?=$__category["name"]?></a>
											<? if(isset($filter["category"]) && $filter["category"] == $__category["id"] && $__category["symlink"] == "by_regions"){ ?>
												<div class="mt10">
													<select data-ui="regions" data-value="<?=(isset($filter["regions"]) ? $filter["regions"] : 0)?>" style="width: 100%">
														<option value="0">&mdash;</option>
														<? foreach($regions as $__region){ ?>
															<option value="<?=$__region["id"]?>"><?=$__region["title"]?></option>
														<? } ?>
													</select>
												</div>
											<? } ?>
										</li>
									<? } ?>
									<li<? if(isset($filter["category"]) && $filter["category"] == "election"){ ?> class="selected"<? } ?>>
										<a href="/news?category=election"><?=t("Вибори 2014")?></a>
										<? if(isset($filter["category"]) && $filter["category"] == "election" && count($electionCandidates) > 0){ ?>
											<div class="mt10">
												<select data-ui="election_candidates" data-ecid="<?=(isset($filter["ecid"]) ? $filter["ecid"] : 0)?>" style="width: 100%">
													<script type="text/javascript">(<?=json_encode($electionCandidates)?>);</script>
												</select>
											</div>
										<? } ?>
									</li>
								</ul>
							</div>
							
						</div>
						
						<? if(count($tags) > 0){ ?>
							<div class="mt15 p15" style="background-color: white">

								<div class="mt5">
									<ul data-uiSwitcher="tags">
										<? if(isset($__query["page"])){ ?><? unset($__query["page"]) ?><? } ?>
										<? foreach($tags as $__tag){ ?>
											<li<? if(isset($filter["tag"]) && $filter["tag"] == $__tag["id"]){ ?> class="selected"<? } ?>>
												<a href="?<?=http_build_query(array_merge($__query, ["tag" => $__tag["id"]]))?>"><?=$__tag["name"]?></a>
											</li>
										<? } ?>
									</ul>
								</div>

							</div>
						<? } ?>
						
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
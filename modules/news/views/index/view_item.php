<div class="header">
	<div>&nbsp;</div>
</div>

<? $GW = [300, 330] ?>

<div class="section mt30">
	
	<div>
		<div style="color: #666"><?=$application->intlDateFormatter->format(strtotime($item["created_at"]))?></div>
	</div>
	
	<div>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					
					<td valign="top" class="pr30">
						<h1 class="fwbold fs25" style="color: #333"><?=$item["title"]?></h1>

						<div class="tags mt10">
							<? foreach ($tags as $tag) { ?><a href="/news?tag=<?=$tag["id"]?>">#<?=$tag["name"]?></a>&nbsp;<? } ?>
						</div>
						
						<div data-uiBox="news_content" style="color: #333"><?=$item["text"]?></div>
						
						<div class="mt30">
							<div data-uiBox="loading">
								<div data-uiBox="preview" class="preview"></div>
							</div>
							
							<div data-uiBox="images" class="mt10">
								<? foreach($item["images"] as $__image){ ?>
									<div class="preview" data-hash="<?=$__image?>" style="background-image: url('/s/img/thumb/200x/<?=$__image?>')"></div>
								<? } ?>
								<div></div>
							</div>
						</div>
					</td>
					
					<td valign="top" width="<?=$GW[0]?>px">
						<div class="p15" style="background-color: white">
							
							<div class="mt5">
								<ul data-uiSwitcher="categories">
									<li<? if( ! ($item["category_id"] > 0)){ ?> class="selected"<? } ?>>
										<a href="/news"><?=t("Усі новини")?></a>
									</li>
									<? foreach($categories as $__category){ ?>
										<li<? if( ! $item["in_election"] && $item["category_id"] == $__category["id"]){ ?> class="selected"<? } ?>>
											<a href="/news?category=<?=$__category["id"]?>"><?=$__category["name"]?></a>
										</li>
									<? } ?>
									<li<? if($item["in_election"]){ ?> class="selected"<? } ?>>
										<a href="/news?category=election"><?=t("Вибори 2014")?></a>
										<? if($item["in_election"] && $item["election_candidate_id"] > 0 && count($electionCandidates) > 0){ ?>
											<div class="mt10">
												<select data-ui="election_candidates" data-ecid="<?=$item["election_candidate_id"]?>" style="width: 100%">
													<script type="text/javascript">(<?=json_encode($electionCandidates)?>);</script>
												</select>
											</div>
										<? } ?>
									</li>
								</ul>
							</div>
							
						</div>
						
						<div class="mt15">
							
							<div style="color: #666"><?=t("Поділитися новиною")?>:</div>
							
							<div class="mt10">
								<table cellspacing="0" cellpadding="0">
									<tbody>
										<tr>
											<td class="pt10" style="line-height: 0">
												<div class="fb-share-button" data-href="http://<?=Uri::getUrl()?><?=Uri::getUrn()?>">Поділитися</div>
											</td>
										</tr>
										<tr>
											<td class="pt10" style="line-height: 0">
												<div class="g-plus" data-action="share" data-annotation="bubble"></div>
											</td>
										</tr>
										<tr>
											<td class="pt10" style="line-height: 0">
												<div data-ui="vk_sharing"></div>
												<script type="text/javascript">
													$(document).ready(function(){
														$("body>section div[data-ui='vk_sharing']")
																.html(VK.Share.button({url: "http://<?=Uri::getUrl()?><?=Uri::getUrn()?>"},{type: "round", text: "Поділитися"}));
													});
												</script>
											</td>
										</tr>
										<tr>
											<td class="pt10" style="line-height: 0">
												<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://<?=Uri::getUrl()?><?=Uri::getUrn()?>" data-lang="ru">Поділитися</a>
												<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							
						</div>
					</td>
					
				</tr>
			</tbody>
		</table>
	</div>
	
</div>
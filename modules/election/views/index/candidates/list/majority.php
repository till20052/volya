<div class="mt15 mb30">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top">
					<h3>На Позачергових Парламентських виборах 2014 року 32 кандидати від партії «ВОЛЯ» балотувалися в одномандатних виборчих округах. Кандидати від «ВОЛІ» були представлені в 13-ти областях та Києві.</h3>
				</td>
				
				<td valign="top" width="<?=$GW[0]?>px">
					<div class="pr30" style="box-sizing: border-box">&nbsp;</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<? foreach($regions as $__regionId => $__region){ ?>
	<div data-uiBox="row" class="mt15">
		
		<div>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>

						<td width="<?=$GW[1]?>px">
							<a data-action="expand" data-state="0" href="javascript:void(0);" class="fs16"><?=$__region["title"]?></a>
						</td>

						<td>
							<span style="color: #666666">Округ<? if(count($__region["county_numbers"]) > 1){ ?>и<? } ?> № <?=implode(", ", $__region["county_numbers"])?></span>
						</td>

					</tr>
				</tbody>
			</table>
		</div>
		
		<? foreach($__region["candidates"] as $__candidate){ ?>
			<div data-uiBox="candidate" class="mt15">
				<table cellspacing="0" cellpadding="0">
					<tbody>
						<tr>

							<td>
								<div class="avatar x150"<? if($__candidate["symlink_avatar"] != ""){ ?> style="background-image: url('/s/img/thumb/ar/<?=$__candidate["symlink_avatar"]?>')"<? } ?>></div>
							</td>

							<td>
								<div>
									<a href="/election/candidates/<?=$__candidate["symlink"]?>" class="fs16"><?=$__candidate["first_name"]." ".$__candidate["last_name"]?></a>
								</div>
								<div class="mt5"><?=$__candidate["announcement"]?></div>
							</td>

							<td>
								<div style="width: <?=$GW[0]?>px">
									<? if( ! $__candidate["is_results_visible"]){ ?>
										<div class="fwbold"><?=t("Виборчий округ №")?><?=$__candidate["county_number"]?></div>
										<div class="fs12"><?=t("Межі округу")?>: <?=RoepDistrictsModel::i()->getCompiledListByField("number", "Одномандатний виборчий округ №".$__candidate["county_number"], [
											"fields" => ["description"]
										])[0]["description"]?></div>
										<? $__contacts = ElectionClass::i()->getCandidateContacts($__candidate["id"], "phone") ?>
										<? if(isset($__contacts["phone"]) && count($__contacts["phone"]) > 0){ ?>
											<div class="mt15 fwbold"><?=t("Штаб кандидата")?>:</div>
											<div><?=implode(", ", $__contacts["phone"])?></div>
										<? } ?>
									<? } else { ?>
										<div class="fwbold tacenter"><?=t("Виборчий округ №")?><?=$__candidate["county_number"]?></div>
										<div class="mt15" style="padding: 0 90px">
											<div class="tacenter vamiddle fs25 fwbold" style="display: table-cell; width: 90px; height: 90px; border-radius: 50px; border: 5px solid<? if($__candidate["place_number"] != 1){ ?> #0181C5<? } else { ?> green<? } ?>; box-sizing: border-box; color: <? if($__candidate["place_number"] != 1){ ?> #0181C5<? } else { ?> green<? } ?>"><?=$__candidate["percent"]?> %</div>
										</div>
										<? if($__candidate["place_number"] == -1){ ?>
											<div class="mt15 fwbold tacenter"><?=$__candidate["place_number"]?> <?=t("місце")?></div>
											<? if($__candidate["place_number"] > 1 && $__candidate["place_number"] < 4){ ?>
												<div class="tacenter" style="color: #666">забракло <?=$__candidate["difference"]?> %</div>
											<? } ?>
										<? } ?>
										<? if($__candidate["votes_count"] > 0){ ?>
											<div class="mt15 fwbold tacenter"><?=$__candidate["votes_count"]?> <?=t("голосів")?></div>
										<? } ?>
									<? } ?>
								</div>
							</td>

						</tr>
					</tbody>
				</table>
			</div>
		<? } ?>
		
	</div>
<? } ?>
<div class="<? if($__iterator != 0){ ?>mt30 <? } ?>p15" style="background-color: white">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>

				<td valign="top" class="pr15" style="width: 130px">
					<div class="avatar x130"<? if($__item["avatar"] != ""){ ?> style="background-image: url('/img/frontend/election/index/candidates/list/association/<?=$__item["avatar"]?>')"<? } ?>></div>
				</td>

				<td valign="top">
					<div class="fs16 fwbold"><?=$__item["name"]?></div>
					<div class="mt5 fsitalic"><?=$__item["subname"]?></div>
					<div class="mt5">
						<span><?=$__item["bio"]?></span>
					</div>
					<div class="mt15">
						<table cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<? if($__item["fb"] != ""){ ?>
										<td class="pr30">
											<a href="<?=$__item["fb"]?>" target="_blank" class="icon">
												<i class="icon-facebook fs18"></i>
												<span><?=t("Фейсбук")?></span>
											</a>
										</td>
									<? } ?>
									
									<? if($__item["tw"] != ""){ ?>
										<td class="pr30">
											<a href="<?=$__item["tw"]?>" target="_blank" class="icon">
												<i class="icon-twitter fs18"></i>
												<span><?=t("Твітер")?></span>
											</a>
										</td>
									<? } ?>

								</tr>
							</tbody>
						</table>
					</div>
				</td>

				<td valign="top" class="cgray fwbold tacenter" style="white-space: nowrap">
					<div>№ <?=$__item["number"]?></div>
					<div class="mt15 p15">
						<div class="icon"<? if( ! $__item["success"]){ ?> style="opacity: 0"<? } ?>><i class="icon-ok fs32" style="padding: 0; color: green"></i></div>
					</div>
				</td>

			</tr>
		</tbody>
	</table>
</div>
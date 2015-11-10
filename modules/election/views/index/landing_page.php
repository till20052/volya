<div>
	<h1 class="fwbold">Партія «ВОЛЯ» на Позачергових Парламентських виборах 2014</h1>
</div>

<? $GW = [300, 330] ?>

<!--<div class="mt5">
	<h3>Вибори мають привести до парламенту не просто «нові обличчя», а людей, здатних втілити нові підходи до творення державної політики. Ми віримо у нову Україну і маємо ВОЛЮ до змін!</h3>
</div>-->

<div class="mt15">
	<table data-ui="images" cellspacing="0" cellpadding="0" class="fixed_table">
		<tbody>
			<tr>
				
				<td style="width: 300px; background-image: url('/img/frontend/election/index/landing_page/program.jpg')">
					<div>
						<a href="/election/program"><?=t("Передвиборча програма")?></a>
					</div>
				</td>
				
				<td></td>
				
				<td style="width: 300px; background-image: url('/img/frontend/election/index/landing_page/candidates.jpg')">
					<div>
						<a href="/election/candidates"><?=t("Наші кандидати")?></a>
					</div>
				</td>
				
				<td></td>
				
				<td style="width: 300px; background-image: url('/img/frontend/election/index/landing_page/agitation.jpg')">
					<div>
						<a href="/election/agitation"><?=t("Агітаційні матеріали")?></a>
					</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<div class="mt30" style="color: #333333">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					
					<div class="fs16 fwbold">
						<span class="mark"><?=t("Офіційні результати Позачергових Парламентських виборів 2014 року")?></span>
					</div>
					
					<h3 class="mt5">За даними ЦВК, Об’єднання «Самопоміч», до списку якого увійшли Люди «ВОЛІ», набирає 10.97% голосів. Опрацьовано 100% бюлетенів.</h3>
					
					<div data-uiBox="charts" class="mt15 p15" style="background-color: white">
						<script>(<?=json_encode($charts)?>);</script>
						<table width="100%" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td colspan="2">
										<div class="tabbar">
											<ul>
												<? foreach($charts["exitpolls"] as $__exitpoll){ ?>
													<li class="tacenter">
														<a href="javascript:void(0);" data-eid="<?=$__exitpoll["id"]?>"><?=$__exitpoll["name"]?></a>
													</li>
												<? } ?>
											</ul>
										</div>
									</td>
								</tr>
								
								<tr>
									<td colspan="2" style="height: 15px"></td>
								</tr>
								
								<tr>
									
									<td width="20%">
										<div class="p15" style="background-color: #106838">
											<div data-uiChart="samopomich" data-cacolor="white" data-isSpecial="1"></div>
										</div>
									</td>
									
									<td>
										<div class="p15">
											<div data-uiChart="other" data-cacolor="black" data-isSpecial="0"></div>
										</div>
									</td>
									
								</tr>
							</tbody>
						</table>
					</div>
					
					<!--<div class="mt30 fs16 fwbold">
						<span class="mark"><?=t("Передвиборча програма")?></span>
					</div>
					
					<h3 class="mt5">Перші п’ять кроків «ВОЛІ» у новому парламенті:</h3>
					
					<div class="mt15 p15" style="background-color: white">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>

									<td width="50%" class="pr15" valign="top">
										<div>
											<div class="fwbold">Крок 1:</div>
											<div>Провести люстрацію</div>
										</div>
									</td>

									<td class="pl15" valign="top">
										<div>
											<div class="fwbold">Крок 4:</div>
											<div>Створити незалежні від олігархів медіа</div>
										</div>
									</td>

								</tr>
								<tr>

									<td width="50%" class="pr15 pt15" valign="top">
										<div>
											<div class="fwbold">Крок 2:</div>
											<div>Ліквідувати корупційні схеми</div>
										</div>
									</td>

									<td class="pl15 pt15" valign="top">
										<div>
											<div class="fwbold">Крок 5:</div>
											<div>Децентралізувати владу</div>
										</div>
									</td>

								</tr>
								<tr>

									<td width="50%" class="pr15 pt15" valign="top">
										<div>
											<div class="fwbold">Крок 3:</div>
											<div>Створити потужну систему оборони</div>
										</div>
									</td>

									<td class="pl15 pt15" valign="top">
										<div>
											<a href="/election/program"><?=t("Переглянути програму")?></a>
										</div>
									</td>

								</tr>
							</tbody>
						</table>
					</div>-->
					
					<h3 class="mt15">Партія «ВОЛЯ» делегувала своїх представників для участі у позачергових виборах до спільного списку з «Об'єднанням «Самопоміч». Окрім партійців «ВОЛІ» та «Самопомочі» до об’єднаного списку увійшли також представники добровольчого батальйону «Донбас», Реанімаційного пакету реформ та незалежні експерти.</h3>
					
					<div class="mt15">
						<table data-ui="members" cellspacing="0" cellpadding="0" class="fixed_table">
							<tbody>
								
								<tr>

									<td valign="top">
										<div class="p5">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tbody>
													<tr>
														<td style="width: 75px">
															<div class="avatar" style="background-image: url('/img/frontend/election/index/candidates/list/association/suslova_web.jpg')"></div>
														</td>
														<td class="pl15">
															Ірина<br />Суслова
														</td>
														<td align="right" valign="top" class="p15 cgray">
															<div>№ 6</div>
															<div class="mt15">
																<div class="icon"><i class="icon-ok fs20" style="padding: 0; color: green"></i></div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>

									<td></td>
									
									<td>
										<div class="p5">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tbody>
													<tr>
														<td style="width: 75px">
															<div class="avatar" style="background-image: url('/img/frontend/election/index/candidates/list/association/sobolev_web.jpg')"></div>
														</td>
														<td class="pl15">
															Єгор<br />Соболєв
														</td>
														<td align="right" valign="top" class="p15 cgray">
															<div>№ 13</div>
															<div class="mt15">
																<div class="icon"><i class="icon-ok fs20" style="padding: 0; color: green"></i></div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>

								</tr>
								
								<tr>

									<td valign="top">
										<div class="p5">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tbody>
													<tr>
														<td style="width: 75px">
															<div class="avatar" style="background-image: url('/img/frontend/election/index/candidates/list/association/miroshnichenko_web.jpg')"></div>
														</td>
														<td class="pl15">
															Іван<br />Мірошниченко
														</td>
														<td align="right" valign="top" class="p15 cgray">
															<div>№ 15</div>
															<div class="mt15">
																<div class="icon"><i class="icon-ok fs20" style="padding: 0; color: green"></i></div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>

									<td></td>
									
									<td>
										<div class="p5">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tbody>
													<tr>
														<td style="width: 75px">
															<div class="avatar" style="background-image: url('/img/frontend/election/index/candidates/list/association/voizizka_web.jpg')"></div>
														</td>
														<td class="pl15">
															Вікторія<br />Войціцька
														</td>
														<td align="right" valign="top" class="p15 cgray">
															<div>№ 22</div>
															<div class="mt15">
																<div class="icon"><i class="icon-ok fs20" style="padding: 0; color: green"></i></div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>

								</tr>
								
								<tr>

									<td valign="top">
										<div class="p5">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tbody>
													<tr>
														<td style="width: 75px">
															<div class="avatar" style="background-image: url('/img/frontend/election/index/candidates/list/association/kostenko_web.jpg')"></div>
														</td>
														<td class="pl15">
															Павло<br />Костенко
														</td>
														<td align="right" valign="top" class="p15 cgray">
															<div>№ 29</div>
															<div class="mt15">
																<div class="icon"><i class="icon-ok fs20" style="padding: 0; color: green"></i></div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>

									<td></td>
									
									<td>
										<div class="p5">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tbody>
													<tr>
														<td style="width: 75px">
															<div class="avatar" style="background-image: url('/img/frontend/election/index/candidates/list/association/nemirovskiy.jpg')"></div>
														</td>
														<td class="pl15">
															Андрій<br />Немировський
														</td>
														<td align="right" valign="top" class="p15 cgray">
															<div>№ 33</div>
<!--															<div class="mt15">
																<div class="icon"><i class="icon-ok fs20" style="padding: 0; color: green"></i></div>
															</div>-->
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>

								</tr>
								
								<tr>

									<td valign="top">
										<div class="p5">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tbody>
													<tr>
														<td style="width: 75px">
															<div class="avatar" style="background-image: url('/img/frontend/election/index/candidates/list/association/kuzmenko.jpg')"></div>
														</td>
														<td class="pl15">
															Олексій<br />Кузменко
														</td>
														<td align="right" valign="top" class="p15 cgray">№ 39</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>

									<td></td>
									
									<td>
										<div class="p5">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tbody>
													<tr>
														<td style="width: 75px">
															<div class="avatar" style="background-image: url('/img/frontend/election/index/candidates/list/association/solodovnikov_web.jpg')"></div>
														</td>
														<td class="pl15">
															Руслан<br />Солодовніков
														</td>
														<td align="right" valign="top" class="p15 cgray">№ 48</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>

								</tr>
								
								<tr>

									<td valign="top">
										<div class="p5">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tbody>
													<tr>
														<td style="width: 75px">
															<div class="avatar" style="background-image: url('/img/frontend/election/index/candidates/list/association/pozdnyakova.jpg')"></div>
														</td>
														<td class="pl15">
															Ганна<br />Познякова
														</td>
														<td align="right" valign="top" class="p15 cgray">№ 52</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>

									<td></td>
									
									<td valign="top">
										<div class="p5">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tbody>
													<tr>
														<td style="width: 75px">
															<div class="avatar" style="background-image: url('/img/frontend/election/index/candidates/list/association/mishcenko_2.jpg')"></div>
														</td>
														<td class="pl15">
															Вячеслав<br />Міщенко
														</td>
														<td align="right" valign="top" class="p15 cgray">№ 58</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>

								</tr>
								
								<tr>
									<td colspan="3" style="padding: 30px 0">
										<a href="/election/candidates/association">Наші кандидати у списку«Об’єднання «Самопоміч»</a>
									</td>
								</tr>
								
							</tbody>
						</table>
					</div>
					
					<? if(count($candidates) > 0){ ?>
						<div class="fs16 fwbold">
							<span class="mark"><?=t("Наші кандидати в одномандатних округах")?></span>
						</div>

						<h3 class="mt5">На Позачергових Парламентських виборах 2014 року 32 кандидати від партії «ВОЛЯ» балотувалися в одномандатних виборчих округах. Кандидати від «ВОЛІ» були представлені в 13-ти областях та Києві.</h3>

						<div class="mt15">
							<div data-uiGrid="candidates">
								<? foreach($candidates as $__candidate){ ?>
									<div class="p5">
										<table width="100%" cellspacing="0" cellpadding="0">
											<tbody>
												<tr>
													<td style="width: 75px">
														<div class="avatar"<? if($__candidate["symlink_avatar"] != ""){ ?> style="background-image: url('/s/img/thumb/at/<?=$__candidate["symlink_avatar"]?>')"<? } ?>></div>
													</td>
													<td class="pl15">
														<div>
															<a href="/election/candidates/<?=$__candidate["symlink"]?>"><?=UserClass::getNameByItem($__candidate, "&fn<br />&ln")?></a>
														</div>
														<? if($__candidate["is_results_visible"]){ ?>
															<div class="mt5 fs11">Виборчий округ № <?=$__candidate["county_number"]?></div>
														<? } ?>
													</td>
													<td align="right" valign="middle" class="p10" style="color: #666">
														<? if($__candidate["is_results_visible"]){ ?>
															<div>
																<div class="tacenter vamiddle fwbold" style="display: table-cell; width: 50px; height: 50px; border-radius: 50px; border: 3px solid green; box-sizing: border-box; color: green"><?=$__candidate["percent"]?> %</div>
															</div>
														<? } else { ?>
															<div>№ <?=$__candidate["county_number"]?></div>
														<? } ?>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								<? } ?>
								<div></div>
							</div>
						</div>
						
						<div class="mt15">
							<a href="/election/candidates">Наші кандидати в одномандатних виборчих округах</a>
						</div>
					<? } ?>
				</td>
				
				<td valign="top" width="<?=$GW[0]?>px">
					<div class="pr30" style="box-sizing: border-box">
						<div class="fs16 fwbold">Новини кампанії</div>
						<? if( ! (count($news) > 0)){ ?>
							<div class="mt15 p15" style="background: white;">
								Намає записів
							</div>
						<? } else { ?>
							<? foreach($news as $__item){ ?>
								<div class="mt15">
									<div style="color: #666"><?=$application->intlDateFormatter->format(strtotime($__item["created_at"]))?></div>
									<div class="mt5">
										<a href="/news/<?=$__item["id"]?>"><?=$__item["title"]?></a>
									</div>
								</div>
							<? } ?>
							<div class="mt15">
								<a href="/news?category=election" style="color: #666">Усі новини</a>
							</div>
						<? } ?>
					</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>


<div>
	<div>

		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
			<tr>

				<td width="630px" class="vatop">
					<header>
						<h1><?=$page['title'][Router::getLang()]?></h1>
					</header>
					<section>

						<div>
							<table cellspacing="0" cellpadding="0">
								<tbody>
								<tr>

									<td>
										<div class="icon">
											<i class="icon-phonealt"></i>
											<span>(0342) 78 40 31</span>
										</div>
									</td>

									<!--<td class="pl15">
										<div class="icon">
											<i class="icon-phonealt"></i>
											<span>+380 97 456 78 89</span>
										</div>
									</td>-->

									<td class="pl15">
										<div class="icon">
											<i class="icon-emailalt"></i>
											<span>
												<a href="mailto:frankivsk@volya.ua">frankivsk@volya.ua</a>
											</span>
										</div>
									</td>

								</tr>
								</tbody>
							</table>
						</div>

						<? if(count($topNews) > 0){ ?>
							<div>
								<header>
									<h1><?=t('ТОП новини')?></h1>
								</header>
								<section>
									<div id="slider">
										<div id="features">
											<? foreach($topNews as $__item){ ?>
												<div onclick="window.location.href='volyz.ua/news/<?=$__item["id"]?>'" style="background: url('http://volya.ua/s/img/thumb/630x/<?=$__item["images"][0]?>') no-repeat; cursor:pointer" title="Test">
													<div>
														<?=$__item['title'][Router::getLang()]?>
													</div>
												</div>
											<? } ?>

										</div>
										<script type="text/javascript">
											$(document).ready(
												function(){
													$('#features').jshowoff();
												}
											);
										</script>
									</div>
								</section>
							</div>
						<? } ?>

						<div data-ui-block="news">
							<header>
								<h1><?=t('Контакти')?></h1>
							</header>
							<section>
								<ul>
									<? if(count($contacts) > 0){ ?>
										<? foreach($contacts as $__item){ ?>
											<li>
												<div><b><?=$__item["title"]?></b></div>
												<div><?=$__item["fname"]?> <?=$__item["lname"]?></div>
												<div><?=$__item["address"]?></div>

												<? $i = 1; ?>
												<? foreach ($__item["contacts"] as $__contact) { ?>
													<div class="icon mt5" style="width: 43%; float: left">
														<i class="icon-<?=$__contact["type"]?>alt"></i>
														<? if($__contact["type"] == "email"){ ?>
															<span>
																<a href="mailto:<?=$__contact["value"]?>"><?=$__contact["value"]?></a>
															</span>
														<? } else { ?>
															<span><?=$__contact["value"]?></span>
														<? } ?>
													</div>
													<? if($i % 2 == 0){ ?>
														<div style="clear:both"></div>
													<? } $i++; ?>
												<? } ?>
											</li>
										<? } ?>
										<li></li>
									<?}else{?>
										<li data-type="empty"><?=t("Контактів немає")?></li>
									<?}?>
								</ul>

								<div data-ui-block="video">
									<header>
										<h1><?=t('Навчання для тих, хто має ВОЛЮ бути депутатом')?></h1>
									</header>
									<section>
										<ul>
											<? $__list = [
												['id' => 'DDXy_PPA7tU', 'title' => 'Лектор Галина Васильченко', 'description' => 'частина 1'],
												['id' => 'OyNQCpahDVA', 'title' => 'Лектор Галина Васильченко', 'description' => 'частина 2'],
												['id' => 'ewDHlOXfDv4', 'title' => 'Лектор Володимир Ковальчук'],
												['id' => 'B7mUYdGGYjE', 'title' => 'Лектор В. Красноштанов, О. Галабала, Ю. Жолоб'],
												['id' => 'NMrdA5rIudg', 'title' => 'Лектор Мирон Дмитрик'],
												['id' => '48mZM-CQmeU', 'title' => 'Лектор Зіновій Мазур'],
												['id' => 'NiecZTp5AAo', 'title' => 'Лектор Тетяна Кулик'],
												['id' => 'BcYCf6co43w', 'title' => 'Лектор Андрій Осіпов', 'description' => 'частина 1'],
												['id' => '97IPuuWrkO4', 'title' => 'Лектор Андрій Осіпов', 'description' => 'частина 2']
											] ?>
											<? foreach($__list as $__item){ ?>
												<li data-vid="<?=$__item['id']?>">
													<div>
														<img src="http://img.youtube.com/vi/<?=$__item['id']?>/hqdefault.jpg" width="100%">
													</div>
													<div>
														<div>
															<a href="javascript:void(0);"><?=$__item['title']?></a>
														</div>
														<? if(isset($__item['description'])){ ?>
															<div><?=$__item['description']?></div>
														<? } ?>
													</div>
												</li>
											<? } ?>
										</ul>
									</section>
								</div>

							</section>
						</div>
					</section>
				</td>

				<td data-ui-block="right" class="vatop pl15">
					<section>

						<div data-ui-block="projects">
							<header>
								<h1><?=t('Проекти')?></h1>
							</header>
							<section>
								<ul>
									<li>
										<a href="http://cdi.volya.ua/">
											<img src="/img/frontend/projects/cdi/banner.gif" width="100%">
										</a>
									</li>
								</ul>
							</section>
						</div>

						<? if(count($volya_people) > 0){ ?>
							<div data-ui-block="volya_peoples">
								<header>
									<h1>
										<?=t('Люди ВОЛI')?>
									</h1>
								</header>
								<section>
									<ul>
										<? if(count($volya_people) < 5) $keys = array_keys($volya_people); else $keys = array_rand($volya_people, 5) ?>
										<? foreach($keys as $__key){ ?>
											<? $__item = $volya_people[$__key]; ?>
											<li data-vid="<?=$__item['id']?>">
												<div data-ui="preview"<? if(count($__item["images"]) > 0){ ?> style="background-image: url('http://volya.ua/s/img/thumb/200x/<?=$__item["images"][0]?>'); width: 81px; height: 50px; background-size: contain; float: left;"<? } ?>></div>
												<div style="float: left; margin-left: 15px; width: 185px">
													<a href="http://volya.ua/news/<?=$__item['id']?>"><?=$__item['title'][Router::getLang()]?></a>
												</div>
												<div style="clear: both"></div>
											</li>
										<?}?>
									</ul>
									<div class="mt30">
										<table width="100%" cellspacing="0" cellpadding="0">
											<td width="49%" class="pr15">
												<hr style='border: 0; border-top: 1px solid #DBD8D0' />
											</td>
											<td>
												<a href="/volya_people" class="v-button" style="white-space: nowrap">
													<span><?=t("Всі новини")?></span>
												</a>
											</td>
											<td width="49%" class="pl15">
												<hr style='border: 0; border-top: 1px solid #DBD8D0' />
											</td>
										</table>
									</div>
								</section>
							</div>
						<? } ?>

						<div data-ui-block="events" style="display: none">
							<header>
								<h1><?=t('Події')?></h1>
							</header>
							<section>
								<ul>
									<li data-type="empty"><?=t("Подій немає")?></li>
								</ul>
							</section>
						</div>

						<div data-ui-block="about">
							<header>
								<h1><?=t('Про організацію')?></h1>
							</header>
							<section><?=$page['text'][Router::getLang()]?></section>
						</div>

					</section>
				</td>

			</tr>
			</tbody>
		</table>

	</div>
</div>

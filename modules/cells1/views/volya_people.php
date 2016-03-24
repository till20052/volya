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
											<span>+380 99 123 45 67</span>
										</div>
									</td>

									<td class="pl15">
										<div class="icon">
											<i class="icon-phonealt"></i>
											<span>+380 97 456 78 89</span>
										</div>
									</td>

									<td class="pl15">
										<div class="icon">
											<i class="icon-emailalt"></i>
										<span>
											<a href="mailto:info@if.volya.ua">info@if.volya.ua</a>
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
								<h1><?=t('ЛЮДИ ВОЛІ')?></h1>
							</header>
							<section>
								<ul>
									<? if(count($volya_people) > 0){ ?>
										<? foreach($volya_people as $__item){ ?>
											<li>
												<div data-ui="preview"<? if(count($__item["images"]) > 0){ ?> style="background-image: url('http://volya.ua/s/img/thumb/200x/<?=$__item["images"][0]?>')"<? } else { ?> style="background-image: url('/img/frontend/cells1/volya.logo.jpg');";<? } ?>></div>
												<div>
													<a href="http://volya.ua/news/<?=$__item['id']?>"><?=$__item['title'][Router::getLang()]?></a>
												</div>
												<div data-ui="datetime"><?=$__item["created_at"]?></div>
											</li>
										<? } ?>
										<li></li>
									<?}else{?>
										<li data-type="empty"><?=t("Новин немає")?></li>
									<?}?>
								</ul>
								<? if(count($volya_people) > 9){ ?>
									<div class="mt15 tacenter">
										<a data-action="load_next_volya_people" href="javascript:void(0);" class="v-button v-button-blue"><?=t('Завантажити ще')?></a>
									</div>
								<?}?>

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

						<? if(count($news) > 0){ ?>
							<div data-ui-block="volya_peoples">
								<header>
									<h1>
										<?=t('Новини')?>
									</h1>
								</header>
								<section>
									<ul>
										<? if(count($news) < 5) $keys = array_keys($news); else $keys = array_rand($news, 5) ?>

										<? foreach($keys as $__key){ ?>
											<? $__item = $news[$__key]; ?>
											<li data-vid="<?=$__item['id']?>">
												<div data-ui="preview" style="<? if(count($__item["images"]) > 0){ ?> background-image: url('http://volya.ua/s/img/thumb/200x/<?=$__item["images"][0]?>')<? } else { ?> background-image: url('/img/frontend/cells1/volya.logo.jpg')<? } ?>; width: 81px; height: 50px; background-size: contain; background-position: center; float: left;"></div>
												<div style="float: left; margin-left: 15px; width: 185px">
													<a href="http://volya.ua/news/<?=$__item['id']?>"><?=$__item['title'][Router::getLang()]?></a>
												</div>
												<div style="clear: both"></div>
											</li>
										<? } ?>
									</ul>
									<div class="mt30">
										<table width="100%" cellspacing="0" cellpadding="0">
											<td width="49%" class="pr15">
												<hr style='border: 0; border-top: 1px solid #DBD8D0' />
											</td>
											<td>
												<a href="/" class="v-button" style="white-space: nowrap">
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

						<? if(count($contacts) > 0){ ?>
							<div data-ui-block="contacts">
								<header>
									<h1><?=t('Контакти')?></h1>
								</header>
								<section>
									<ul>
										<? foreach ($contacts as $contact) { ?>
											<li>
												<div><b><?=$contact["title"]?></b></div>
												<div><?=$contact["fname"]?> <?=$contact["lname"]?></div>
												<div class="icon mt5" style="float: none">
													<i class="icon-phonealt"></i>
													<span><?=$contact["contacts"][0]["value"]?></span>
												</div>
												<? if(isset($contact["contacts"][1])){ ?>
													<div class="icon ml10">
														<i class="icon-emailalt"></i>
														<span>
															<a href="mailto:<?=$contact["contacts"][1]["value"]?>"><?=$contact["contacts"][1]["value"]?></a>
														</span>
													</div>
												<? } ?>
											</li>
										<? } ?>
									</ul>
									<div class="mt30">
										<table width="100%" cellspacing="0" cellpadding="0">
											<td width="49%" class="pr15">
												<hr style='border: 0; border-top: 1px solid #DBD8D0' />
											</td>
											<td>
												<a href="/contacts" class="v-button" style="white-space: nowrap">
													<span><?=t("Всі контакти")?></span>
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
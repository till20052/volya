<div>
	<div>

		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
			<tr>

				<td width="630px" class="vatop">
					<header style="border: none">
						<h3>Партія «ВОЛЯ»</h3>
						<h1><?=t('Інститут управління громадами')?></h1>
					</header>
					<section>

						<nav>
							<ul>
								<li>
									<a href="/program" class="icon">
										<i class="icon-appointment-agenda"></i>
										<span><?=t("Програма Інституту")?></span>
									</a>
								</li>
							</ul>
						</nav>

						<div data-ui-block='info'>
							<header>
								<h1><?=$about['title'][Router::getLang()]?></h1>
							</header>
							<section><?=$about['text'][Router::getLang()]?></section>
						</div>

						<div data-ui-block="news">
							<header>
								<h1><?=t('Новини')?></h1>
							</header>
							<section>
								<ul>
									<? if(count($news) > 0){ ?>
										<? $application->intlDateFormatter->setPattern("d MMMM") ?>
										<? foreach($news as $__item){ ?>
											<li>
												<div data-ui="preview"<? if(count($__item["images"]) > 0){ ?> style="background-image: url('http://volya.ua/s/img/thumb/150x100/<?=$__item["images"][0]?>')"<? } ?>></div>
												<div>
													<a href="http://volyacd .ua/news/<?=$__item['id']?>"><?=$__item['title'][Router::getLang()]?></a>
												</div>
												<div data-ui="datetime"><?=$application->intlDateFormatter->format(strtotime($__item["created_at"]))?></div>
											</li>
										<? } ?>
										<li></li>
									<? } else { ?>
										<li data-type="empty"><?=t("Поки ще немає новин")?></li>
									<? } ?>
								</ul>
							</section>
						</div>

					</section>
				</td>

				<td data-ui-block="right" class="vatop pl15">
					<section>

						<div>
							<img src="/img/frontend/projects/cdi/iug_logo_new-01.jpg" width="100%">
						</div>
						
						<div data-ui-block="projects">
							<header>
								<h1><?=t('Анкета учасника')?></h1>
							</header>
							<section>
								<ul>
									<li class="tacenter">
										<a data-action="open_form" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Заповнити анкету")?></a>
									</li>
								</ul>
							</section>
						</div>

					</section>
				</td>

			</tr>
			</tbody>
		</table>

	</div>
</div>
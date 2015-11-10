<div ui-window="election.index.candidates.item.support" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Підтримати кандидата")?></h2>
	</div>
	
	<div class="mt15">
		<hr />
	</div>
	
	<div data-uiBox="form" class="mt15 fs14">
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					
					<td valign="top" width="50%" class="pr15">
						<div><?=t("Дякуємо за бажання підтримати цього кандидата. Будь ласка, заповніть форму, з контактними данними для того, щоб бути в курсі перебігу компанії у вашому регіоні на новин партії.")?></div>
						<div class="mt15">
							<?=t("Якщо ви вкажете, що бажаєте долучитися до компанії у якості волонтера, спостерігача або члена комісії - вам також будуть надіслані усі необхідні інструкції.")?>
						</div>
					</td>
					
					<td valign="top" class="pl15">
						<div>
							<form data-candidateId="<?=$candidate["id"]?>" action="/election/index/j_save_helper" method="post">
								
								<div>
									<div><?=t("Ваше ім'я")?></div>
									<div>
										<input type="text" id="name" class="textbox" style="width: 100%" />
									</div>
								</div>
								
								<div class="mt15">
									<div><?=t("Ел. пошта")?></div>
									<div>
										<input type="text" id="email" class="textbox" style="width: 100%" />
									</div>
								</div>
								
								<div class="mt15">
									<div><?=t("Телефон")?> <span style="color: #666666">(за бажанням)</span></div>
									<div>
										<div class="tx-phone" style="width: 100%">
											<span>+38</span>
											<span>
												<input type="text" data-ui="phone" />
											</span>
										</div>
									</div>
								</div>
								
								<div class="mt15">
									<div data-uiBox="volunteer_groups">
										<div>
											<label><input type="checkbox" id="i_want_to_be_a_helper" /><span> <?=t("Я готовий долучитися у якості волонтера, спостерігача або члена комісії")?></span></label>
										</div>
									</div>
								</div>
								
								<div class="mt15">
									<a data-action="submit" href="javascript:void(0);" class="v-button v-button-blue icon">
										<i class="icon-fblike"></i>
										<span><?=t("Підтримати")?></span>
									</a>
								</div>
								
							</form>
						</div>
					</td>
					
				</tr>
			</tbody>
		</table>
	</div>
	
	<div data-uiBox="success" class="mt15 fs16 p15" style="padding-top: 0">
		
		<div>Дякуємо за бажання підтримати цього кандидата. Будь ласка, порекомендуйте сторінку кандидата вашим друзям у соціальних мережах, щоби якомога більше людей отримали інформацію про його програму.</div>
		
		<div class="mt15">
			<table cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td class="pl10" style="line-height: 0">
							<div class="fb-share-button" data-href="http://<?=Uri::getUrl()?><?=Uri::getUrn()?>">Поділитися</div>
						</td>
						<td class="pl10" style="line-height: 0">
							<div class="g-plus" data-action="share" data-annotation="bubble"></div>
						</td>
						<td class="pl10" style="line-height: 0">
							<div data-ui="vk_sharing"></div>
							<script type="text/javascript">
								$(document).ready(function(){
									$("body>div[ui-box='windows'] div[data-ui='vk_sharing']")
											.html(VK.Share.button({url: "http://<?=Uri::getUrl()?><?=Uri::getUrn()?>"},{type: "round", text: "Поділитися"}));
								});
							</script>
						</td>
						<td class="pl10" style="line-height: 0">
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://<?=Uri::getUrl()?><?=Uri::getUrn()?>" data-lang="ru">Поділитися</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="mt15">
			<hr />
		</div>
		
		<div class="mt15" style="color: #666666">
			<div>Також ви вказали, що готові приєднатися до нашої виборчої кампанії. Детальну інформацію про те, як стати учасником команди «ВОЛІ» на цих виборах та про конкретні наступні кроки, ми переслали вам на електронну пошту. Зараз ви можете переглянути інформацію на нашому сайті:</div>
			<div class="mt15">
				<ul>
					<li>
						<a href="/election/helping#volunteers">Які у нас є задачі для агітаторів та як стати агітатором «ВОЛІ»</a>
					</li>
					<li>
						<a href="/election/helping#observers">Як стати офіційним спостерігачем від «ВОЛІ» на виборах</a>
					</li>
					<li>
						<a href="/election/helping#members">Як стати членом дільничної виборчої комісії</a>
					</li>
				</ul>
			</div>
			<div class="mt15">Якщо ви захочете спитати, як допомогти цьому кандидату у його виборчій кампанії — звертайтеся до штабу кандидата за телефоном <span class="fwbold"><? if(isset($candidate["contacts"]["phone"]) && count($candidate["contacts"]["phone"]) > 0){ ?><?=implode(", ", $candidate["contacts"]["phone"])?><? } ?></span></div>
		</div>
		
	</div>
	
</div>
<div>
	<h1 class="fwbold">Агітаційні матеріали</h1>
</div>

<div class="mt5">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<div>
						<h3>Друзі, ми дуже вдячні вам за підтримку. Зараз як ніколи маємо діяти спільно, адже зміни у країні залежать від кожного з нас. Приєднуйтесь, долучайте однодумців — разом ми непереможні!</h3>
						<h3 class="mt5">Якщо ви хочете підтримати нас на позачергових виборах у парламент і допомогти нам мобілізувати виборців — завантажуйте ці матеріали та використовуйте їх для самостійної агітації за партію «ВОЛЯ» та наших кандидатів.</h3>
					</div>
					
					<div class="mt30 dnone">
						<ul data-uiSwitch="general">
							<li>
								<a href="javascript:void(0);"><?=t("Загальнопартійна агітація")?></a>
							</li>
							<li>
								<a href="javascript:void(0);"><?=t("Конкретний кандидат")?></a>
								<select data-ui="candidates" class="ml5">
									<option value="0">&mdash;</option>
									<? foreach($candidates as $__candidate){ ?>
										<option value="<?=$__candidate["id"]?>"><?=$__candidate["first_name"]?> <?=$__candidate["last_name"]?></option>
									<? } ?>
								</select>
							</li>
						</ul>
					</div>
					
<!--					<div class="mt15">
						<hr />
					</div>-->
					
					<div class="mt15">
						<ul data-uiSwitch="categories"></ul>
					</div>
					
					<div class="mt15">
						<div data-ui="agitations">
							<script type="text/x-kendo-template" id="group">
								<div data-ui="group" data-name="#=name#">
									<div>#=name#</div>
									<div>
										<div></div>
									</div>
								</div>
							</script>
							<script type="text/x-kendo-template" id="item">
								<div data-ui="item">
									<div>
										<div class="preview" style="background-image: url('/s/img/thumb/ar/#=image#')"></div>
									</div>
									<div class="mt15 tacenter">
										<a href="/s/storage/#=file#" class="icon">
											<i class="icon-download-alt"></i>
											<span><?=t("Завантажити")?></span>
										</a>
									</div>
								</div>
							</script>
						</div>
					</div>
				</td>
				
				<td valign="top" width="300px">
					<div data-uiBox="right_side">
						
						<div>Ви також можете взяти друковані агітаційні матеріали у передвиборчому штабі кандидата «ВОЛІ» у вашому окрузі. Оберіть округ, щоби дізнатись контактний телефон:</div>
						
						<div class="mt15" style="font-size: 13px">
							<select data-ui="counties" style="width: 300px">
								<script>(<?=json_encode(array_merge([
									["id" => 0, "county_number" => t("Центральний штаб партії «ВОЛЯ»"), "contacts" => [
										"email" => ["org.volya@gmail.com"],
										"phone" => ["0 800 30 78 77"]
									]]
								], $counties))?>);</script>
							</select>
						</div>
						
						<div class="mt15 fwbold">
							<div data-uiBox="email">Ел. пошта: <span style="white-space: nowrap"></span></div>
							<div data-uiBox="phone">Тел.: <span style="white-space: nowrap"></span></div>
						</div>
						
						<div class="mt15">Будь ласка, попередньо зателефонуйте за цим номером, щоби заздалегідь домовитись про візит. Будемо раді бачити вас.</div>
						
					</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<div class="mt30">
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
							$("body>section div[data-ui='vk_sharing']")
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

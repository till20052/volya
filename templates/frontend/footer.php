<footer>
	
	<div>
		
		<div>
			
			<ul>
				<li>
					<a href="https://www.facebook.com/volya.ua" target="_blank" class="facebook"><?=t("Мережа вільних людей в Facebook")?></a>
				</li>
				<li>
					<a href="https://vk.com/uavolya" target="_blank" class="vkontakte"><?=t("Мережа вільних людей в Вконтакті")?></a>
				</li>
				<li>
					<a href="https://twitter.com/uavolya" target="_blank" class="twitter"><?=t("Мережа вільних людей в Twitter")?></a>
				</li>
				<li>
					<a href="https://plus.google.com/u/0/+VOLYAUA/posts" target="_blank" class="googleplus"><?=t("Мережа вільних людей в Google+")?></a>
				</li>
				<li>
					<a href="https://www.youtube.com/channel/UCWYi38akdU0YuF2f4sdX7mg" target="_blank" class="youtube"><?=t("Мережа вільних людей в YouTube")?></a>
				</li>
<!--				<li>
					<a href="http://instagram.com/volya_ua" target="_blank" class="instagram"><?=t("Мережа вільних людей в Instagram")?></a>
				</li>-->
			</ul>
		
		</div>
		
	</div>
	
	<div>
		
		<div>
			
			<ul>
				
				<li>
					<a href="/">
						<img src="/img/frontend/logo.png" alt="" />
					</a>
				</li>
				
				<li>
					<div>
						<ul data-ui-menu="footer">
							<? foreach($mainMenu as $menuItem){ ?>
							<li>
								<a href="<?=$menuItem["href"]?>"><?=$menuItem["name"][Router::getLang()]?></a>
							</li>
							<? } ?>
							<? if(UserClass::i()->isAuthorized()){ ?>
							<li>
								<a href="/seminar"><?=t('Семінар')?></a>
							</li>
							<? } ?>
							<li>
								<a href="/subsydia"><?=t('Субсидія')?></a>
							</li>
							<li>
								<a href="/hromada"><?=t('Об\'єднання громад')?></a>
							</li>
						</ul>
					</div>
				</li>
				
				<? if( ! UserClass::i()->isAuthorized()){ ?>
				<li>
					<div>
						<a href="/profile/registration" class="icon v-button v-button-blue">
							<i class="icon-plus-sign"></i>
							<span><?=t("Приєднатися")?></span>
						</a>
					</div>
				</li>
				<? } ?>
				
			</ul>
		
		</div>
		
	</div>
	
	<div>
		
		<div>
			
			<div>&COPY; <?=date("Y")?>, <?=t("Мережа вільних людей. Всі права захищені")?></div>
		
		</div>
		
	</div>
	
</footer>
<header>
	
	<div>
		
		<div>
			
			<div>
				
				<div>
					<div data-uid="logo" style="/*margin-top: -100px*/">
						<a href="/">
							<img src="/img/frontend/logo<?=(Router::getModule() == "cells1" ? "_prikarpattya" : "")?>.png" alt="" />
						</a>
					</div>
				</div>
				
				<div>
					<ul>
<!--						<li>
							<a href="mailto:info@volya.ua" class="icon">info@volya.ua</a>
						</li>
						<li>
							<a href="#" class="icon">
								<i class="icon-circleu"></i>
								<span><?=t("Громада і депутати")?></span>
							</a>
						</li>
						<li>
							<a href="#" class="icon">
								<i class="icon-circleu"></i>
								<span><?=t("Владу - громадам!")?></span>
							</a>
						</li>-->
					</ul>
				</div>
				
				
				<div>
					
					<ul>
						<li>
							<a href="mailto:info@volya.ua" class="icon">
								<i class="icon-reademail"></i>
								<span>info@volya.ua</span>
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="icon">
								<i class="icon-phonealt"></i>
								<span>0 800 30 78 77</span>
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="icon">
								<i class="icon-phonealt"></i>
								<span>044 337 38 47</span>
							</a>
						</li>
						<? if( ! UserClass::i()->isAuthorized()){ ?>
						<li>
							<a href="javascript:AppLogin.open();" class="icon">
								<i class="icon-enter"></i>
								<span><?=t("Увійти")?></span>
							</a>
							<div data-ui-popup="login" class="dnone">
								<span class="bubble"></span>
								<div>
									<div class="tacenter">
										<img src="/kendo/styles/Volya/loading_2x.gif" />
									</div>
								</div>
							</div>
						</li>
						<? } ?>
					</ul>
				</div>
				
			</div>
			
		</div>
		
	</div>
	
	<div>
		
		<div>
			
			<div>
				
				
				<div>
					<? include "header/main_menu.php" ?>
				</div>

				<div class="taright" style="line-height: 0">
					<? if( ! UserClass::i()->isAuthorized()){ ?>
						<? if(Router::getModule() != "election"){ ?>
							<a href="http://volya.ua/profile/registration" class="icon v-button v-button-blue">
								<i class="icon-plus-sign"></i>
								<span><?=t("Приєднатися")?></span>
							</a>
						<? } ?>
					<? } else { ?>
						<ul data-ui-menu="profile">
							<li>
								<a href="/profile">
									<!-- START AVATAR -->
									<div class="avatar avatar-2x"<? if(UserClass::i()->getAvatar() != ""){ ?> style="background-image:url('http://volya.ua/s/img/thumb/ai/<?=UserClass::i()->getAvatar()?>')"<? } ?>>
										<? if(UserClass::i()->getAvatar() == ""){ ?>
											<i class="icon-user"></i>
										<? } ?>
									</div>
									<!-- END AVATAR -->
								</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="icon">
									<i class="icon-menu"></i>
								</a>
								<div data-ui-popup="profile" class="dnone">
									<span class="bubble"></span>
									<div style="padding-left: 40px;">
										<? if(UserClass::i()->hasCredential(774)){ ?>
											<div>
												<a href="http://volya.ua/admin" class="icon"><span>*<?=t("Адмін")?></span><i class="icon-controlpanelalt"></i></a>
											</div>
										<? } ?>

										<? //if($registerUser["credential_level_id"] > 0){ ?>
											<div>
												<a href="http://volya.ua/register" class="icon"><span>*<?=t("Реєстр")?></span><i class="icon-branch"></i></a>
											</div>
										<? //} ?>
<!--										<div>
											<a href="/profile/friends" class="icon"><span><?=t("Моє коло")?></span><i class="icon-groups-friends"></i></a>
										</div>
										<div>
											<a href="/profile/messages" class="icon"><span><?=t("Повідомлення")?></span><i class="icon-socialnetwork"></i></a>
										</div>-->
<!--										<div>
											<a href="javascript:void(0);" class="icon"><span><?=t("Налаштування")?></span><i class="icon-settingstwo-gearalt"></i></a>
										</div>-->
										<div>
											<a href="javascript:void(0);" id="sign_out" class="icon"><span><?=t("Вихід")?></span><i class="icon-exit"></i></a>
										</div>
									</div>
								</div>
							</li>
						</ul>
					<? } ?>
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</header>

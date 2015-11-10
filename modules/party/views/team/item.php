<div class="item">
	<? // Console::log($__item) ?>
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td width="304px" valign="top">
					<div class="avatar x300" style="background-image: url('/s/img/thumb/as/<?=$__item["photo"]?>')"></div>
				</td>
				
				<td valign="top" class="pl15">
					
					<div>
						<span class="fwbold fs20"><?=$__item["name"][Router::getLang()]?></span>
					</div>
					
					<div class="mt5">
						<span class="fwbold fs16"><?=UserClass::getAge($__item["age"])?>, <?=$__item["job"][Router::getLang()]?></span>
					</div>
					
					<div class="mt5">
						<span><?=$__item["bio"][Router::getLang()]?></span>
					</div>
					
					<div class="mt5">
						<ul class="links">
							<? $__linksDesc = [
								"facebook.com" => [
									"name" => t("Фейсбук"),
									"icon" => "facebook"
								],
								"platforma-reform.org" => [
									"name" => t("Реанімаційний пакет реформ"),
									"icon" => "linkalt"
								],
								"uu-travel.com" => [
									"name" => t("Унікальна україна"),
									"icon" => "linkalt"
								],
								"derevyanko.org" => [
									"name" => t("Особистий сайт"),
									"icon" => "linkalt"
								],
								"idi.kiev.ua" => [
									"name" => t("Міжнародний інститут демократій"),
									"icon" => "linkalt"
								]
							] ?>
							<? foreach($__item["links"] as $__link){ ?>
								<? foreach($__linksDesc as $__key => $__data){ ?>
									<? if(strpos($__link, $__key) === false){ ?>
										<? continue ?>
									<? } ?>
									<? break ?>
								<? } ?>
								<li>
									<a href="<?=$__link?>" target="_blank" class="icon">
										<i class="icon-<?=$__data["icon"]?>"></i>
										<span><?=$__data["name"]?></span>
									</a>
								</li>
							<? } ?>
						</ul>
					</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>
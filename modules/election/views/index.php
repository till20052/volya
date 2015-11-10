<div class="header">
	<div>
		<ul data-uiSwitcher>
			<li<? if(Router::getMethod() == "program"){ ?> class="selected"<? } ?>>
				<? if(Router::getMethod() != "program"){ ?>
					<a href="/election/program">
				<? } ?>
					<?=t("Передвиборча программа")?>
				<? if(Router::getMethod() != "program"){ ?>
					</a>
				<? } ?>
			</li>
			<li<? if(Router::getMethod() == "candidates"){ ?> class="selected"<? } ?>>
				<? if(
						Router::getMethod() != "candidates"
						|| (isset($submenuClickable) && $submenuClickable)
				){ ?>
					<a href="/election/candidates">
				<? } ?>
					<?=t("Наші кандидати")?>
				<? if(
						Router::getMethod() != "candidates"
						|| (isset($submenuClickable) && $submenuClickable)
				){ ?>
					</a>
				<? } ?>
			</li>
			<li<? if(Router::getMethod() == "agitation"){ ?> class="selected"<? } ?>>
				<? if(Router::getMethod() == "agitation"){ ?>
					<?=t("Агітаційні матеріали")?>
				<? } else { ?>
					<a href="/election/agitation"><?=t("Агітаційні матеріали")?></a>
				<? } ?>
			</li>
<!--			<li<? if(Router::getMethod() == "helping"){ ?> class="selected"<? } ?>>
				<? if(Router::getMethod() == "helping"){ ?>
					<?=t("Допомогти на виборах")?>
				<? } else { ?>
					<a href="/election/helping"><?=t("Допомогти на виборах")?></a>
				<? } ?>
			</li>-->
		</ul>
	</div>
</div>

<div class="section mt30">
	
	<? include "index/".(Router::getMethod() != "execute" ? Router::getMethod() : "landing_page").".php" ?>
	
</div>
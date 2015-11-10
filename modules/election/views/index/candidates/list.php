<div>
	<h3 class="fwbold fs25" style="color: #858383">«ВОЛЯ» на позачергових виборах у парламент 26 жовтня 2014</h3>
</div>

<div class="mt15">
	<ul data-uiSwitcher>
		<li<? if(is_array($subView) && $subView[1] == "majority"){ ?> class="selected"<? } ?>>
			<? if(is_array($subView) && $subView[1] == "majority"){ ?>
				<?=t("За мажоритарними округами")?>
			<? } else { ?>
				<a href="/election/candidates"><?=t("За мажоритарними округами")?></a>
			<? } ?>
		</li>
		<li<? if(is_array($subView) && $subView[1] == "association"){ ?> class="selected"<? } ?>>
			<? if(is_array($subView) && $subView[1] == "association"){ ?>
				<?=t("За списком ")?>&laquo;Об’єднання &laquo;Самопоміч&raquo;
			<? } else { ?>
				<a href="/election/candidates/association"><?=t("За списком ")?>&laquo;Об’єднання &laquo;Самопоміч&raquo;</a>
			<? } ?>
		</li>
	</ul>
</div>

<? $GW = [300, 330] ?>

<? include "list/".(is_array($subView) ? $subView[1] : $subView).".php" ?>
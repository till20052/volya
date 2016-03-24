<div class="header">
	<div>
		<ul data-uiSwitcher>
			
			<li<? if($selected == "team"){ ?> class="selected"<? } ?>>
				<? if($selected == "team"){ ?>
					<?=t("Команда")?>
				<? } else { ?>
					<a href="/party/team"><?=t("Команда")?></a>
				<? } ?>
			</li>
			
			<li<? if($selected == "finances"){ ?> class="selected"<? } ?>>
				<? if($selected == "finances"){ ?>
					<?=t("Фінанси")?>
				<? } else { ?>
					<a href="/party/finances"><?=t("Фінанси")?></a>
				<? } ?>
			</li>
			
			<li<? if($selected == "documents"){ ?> class="selected"<? } ?>>
				<? if($selected == "documents"){ ?>
					<?=t("Документи")?>
				<? } else { ?>
					<a href="/party/documents"><?=t("Документи")?></a>
				<? } ?>
			</li>
			
			<li<? if($selected == "agitation"){ ?> class="selected"<? } ?>>
				<? if($selected == "agitation"){ ?>
					<?=t("Агітація")?>
				<? } else { ?>
					<a href="/party/agitation"><?=t("Агітація")?></a>
				<? } ?>
			</li>
			
		</ul>
	</div>
</div>
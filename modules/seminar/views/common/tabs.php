<div class="tabbar">
	<ul>
		<li<? if(($tab == "legislation") || ( ! isset($tab))){ ?> class="selected"<? } ?>>
			<a href="/seminar/legislation"><?=t("Законодавство")?></a>
		</li>
		<li<? if($tab == "materials"){ ?> class="selected"<? } ?>>
			<a href="/seminar/materials"><?=t("Методичні матеріали")?></a>
		</li>
		<li<? if($tab == "statute"){ ?> class="selected"<? } ?>>
			<a href="/seminar/statute"><?=t("Статут ТГ")?></a>
		</li>
		<li<? if($tab == "video"){ ?> class="selected"<? } ?>>
			<a href="/seminar/video"><?=t("Відео")?></a>
		</li>
		<li<? if($tab == "links"){ ?> class="selected"<? } ?>>
			<a href="/seminar/links"><?=t("Посилання")?></a>
		</li>
	</ul>
</div>
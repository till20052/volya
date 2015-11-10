<div ui-window="cells.index.list.roep_selection" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Вибір дільниці")?></h2>
	</div>
	
	<div data-uiBox="1" class="mt30" style="padding-bottom: 45px">
		<table width="100%">
			<tbody>
				
				<tr>
					<td class="taright pr15" style="width: 25%"><?=t("Назва регіону України")?></td>
					<td>
						<select data-ui="region" style="width: 75%"></select>
					</td>
				</tr>
				
			</tbody>
		</table>
	</div>
	
	<div data-uiBox="2" class="mt15" style="padding-bottom: 45px">
		
		<div>
			<a href="javascript:void(0);" id="back" class="icon v-button">
				<i class="icon-chevron-left"></i>
				<span><?=t("Назад")?></span>
			</a>
		</div>
		
		<div class="mt15">
			<table data-ui="districts">
				<script id="options">({
					columns: [
						{title: "<?=t("Номер округу")?>", width: "35%"},
						{title: "<?=t("Опис меж округу")?>"}
					]
				});</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">
						<a href="javascript:void(0);" data-event="get_plots" data-id="#=id#">#=number#</a>
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5">#=description#</div>
				</script>
			</table>
		</div>
	</div>
	
	<div data-uiBox="3" class="mt15" style="padding-bottom: 45px">
		
		<div>
			<a href="javascript:void(0);" id="back" class="icon v-button">
				<i class="icon-chevron-left"></i>
				<span><?=t("Назад")?></span>
			</a>
		</div>
		
		<div class="mt15">
			<table data-ui="plots">
				<script id="options">({
					columns: [
						{title: "<?=t("Номер дільниці")?>", width: "15%"},
						{title: "<?=t("Опис меж дільниці")?>"},
						{title: "<?=t("Адреса приміщення для голосування / Адреса дільничної виборчої комісії")?>", width: "35%"}
					]
				});</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">
						<a href="javascript:void(0);" data-event="select_plot" data-id="#=id#">#=number#</a>
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5">#=borders#</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5">#=address#</div>
				</script>
			</table>
		</div>
	</div>
	
</div>
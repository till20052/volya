<div ui-window="cells.index.users_finder" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Пошук людей")?></h2>
	</div>

	<div class="mt30">
		
		<div>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						
						<td class="taright pr15"><?=t("Пошук")?></td>
						<td>
							<input type="text" id="q" class="k-textbox" style="width: 100%" />
						</td>
						<td class="pl15">
							<input type="button" id="find" value="<?=t("Знайти")?>" class="k-button" />
						</td>
						
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="mt15">
			<table data-ui="list">
				<script id="options">({
					columns: [
						{title: "<?=t("UID")?>", width: "10%"},
						{title: "<?=t("Інформація")?>"},
						{title: "<?=t("Статус")?>", width: "25%"},
						{title: "<?=t("Дії")?>", width: "20%"}
					]
				});</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">#=id#</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5">
						<div class="fwbold">#=name#</div>
						# if(region_name != ""){ #
							<div>#=region_name## if(city_name != ""){ #, #=city_name## } #</div>
						# } #
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">#=(function(type){
						var __type = " - не встановлено";
						switch(parseInt(type)){
							case 1:
								__type = "<?=t("Користувач")?>";
								break;
							case 50:
								__type = "<?=t("Прихильник")?>";
								break;
							case 99:
								__type = "<?=t("Кандидат в Члени партії ВОЛЯ")?>";
								break;
							case 100:
								__type = "<?=t("Член партії ВОЛЯ")?>";
								break;
						}
						return __type;
					}(type))#</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5">
						<a href="javascript:void(0);" data-event="add_user" data-id="#=id#" class="v-button" style="width: 100%"><?=t("Додати")?></a>
					</div>
				</script>
			</table>
		</div>
		
		<div class="mt15" data-uiList="selected_users" style="border: 1px solid #dadada; height: 100px; overflow: auto; padding: 0 0 5px 5px">
			<script type="text/x-kendo-template">
				<div data-item="#=id#" data-name="#=name#" class="fleft mt5 mr5 p5" style="background: \#efefef">
					<table width="100%">
						<td>
							<div class="fwbold">#=name#</div>
							# if(region_name != ""){ #
								<div>#=region_name## if(city_name != ""){ #, #=city_name## } #</div>
							# } #
						</td>
						<td class="taright">
							<a href="javascript:void(0);" data-event="remove_user" class="icon"><i class="icon-remove"></i></a>
						</td>
					</table>
				</div>
			</script>
			<div class="cboth"></div>
		</div>
		
		<div class="mt15 tacenter">
			<a href="javascript:void(0);" id="add_users" class="v-button v-button-blue"><?=t("Додати")?></a>
		</div>
		
	</div>
</div>
<div ui-window="admin.register.cells.viewer" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Переглядач")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<div class="tacenter fwbold fs20">
			<div><?=t("Первиний осередок партії ВОЛЯ №")?><span id="number"></span></div>
		</div>
		
		<div class="mt15" style="border-bottom: 1px solid #CCC"></div>
		
		<div class="mt15">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="200px" class="vatop taright"><?=t("Дата установчих зборів")?>:</td>
						<td class="pl15">
							<span id="started_at"></span>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Місцезнаходження")?></span>
		</div>
		
		<div class="mt5">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="200px" class="vatop taright"><?=t("Населений пункт")?>:</td>
						<td class="pl15">
							<span id="locality"></span>
						</td>
					</tr>
					
					<tr>
						<td class="vatop taright"><?=t("Адреса")?>:</td>
						<td class="pl15">
							<span id="address"></span>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Учасники")?></span>
		</div>
		
		<div class="mt5">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td class="vatop taright"><?=t("Засновник")?>:</td>
						<td class="pl15">
							<span id="creator"></span>
						</td>
					</tr>
					
					<tr>
						<td width="200px" class="vatop taright">Учасники:</td>
						<td class="pl15">
							<span id="members"></span>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Дільниці")?></span>
		</div>
		
		<div class="mt5">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td class="vatop taright"><?=t("Номер")?>:</td>
						<td class="pl15">
							<span id="polling_places_numbers"></span>
						</td>
					</tr>
					
					<tr>
						<td width="200px" class="vatop taright">Границі:</td>
						<td class="pl15">
							<span id="polling_places_borders"></span>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Сканкопії документів")?></span>
		</div>
		
		<div class="mt15">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="200px" class="taright"><?=t("Документи")?>:</td>
						<td class="pl15">
							<div id="documents"></div>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
	</div>
	
</div>
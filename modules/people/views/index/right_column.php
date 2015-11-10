<div>
	<div>
		<h3><?=t("Область")?></h3>
	</div>
	<div>
		<select data-ui="region" style="width: 100%"></select>
	</div>
</div>

<div data-uiBox="area" class="mt15">
	<div>
		<h3><?=t("Район")?></h3>
	</div>
	<div>
		<div data-uiCover="area" class="cover"></div>
		<select data-ui="area" style="width: 100%">
			<script type="text/x-kendo-template" id="valueTemplate">
				<div>
					# if(typeof data.area != "undefined"){ #
						#=data.area#
					# } else { #
						#=data.title#
					# } #
				</div>
			</script>
			<script type="text/x-kendo-template" id="template">
				<div>
					# if(typeof data.area != "undefined"){ #
						#=data.area#
					# } else { #
						#=data.title#
					# } #
				</div>
			</script>
		</select>
	</div>
</div>

<div data-uiBox="city" class="mt15">
	<div>
		<h3><?=t("Місто")?></h3>
	</div>
	<div>
		<div data-uiCover="city" class="cover"></div>
		<select data-ui="city" style="width: 100%">
			<script type="text/x-kendo-template" id="template">
				<div class="fwbold">#=data.title#</div>
				# if(typeof data.area != "undefined"){ #
					<div>#=data.area#</div>
				# } #
			</script>
		</select>
	</div>
</div>

<div class="mt30 tacenter">
	<a href="javascript:void(0);" id="search" class="v-button v-button-blue" style="width:100%"><?=t("Пошук")?></a>
</div>
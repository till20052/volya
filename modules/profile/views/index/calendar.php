<div data-uiBox="calendar">
	
	<script id="data">(<?=json_encode(array(
		"events_dates" => $profile["events_dates"]
	))?>);</script>
	
	<div class="header">
		<h3><?=t("Календар")?></h3>
	</div>
	
	<div class="section">
		
		<div>
			<div data-uiCalendar="ical">
				<script type="text/x-kendo-template" id="header">
					<div class="k-header">
						<div>
							<a href="javascript:void(0);" data-ui="left" class="icon">
								<i class="icon-chevron-left"></i>
							</a>
						</div>
						<div></div>
						<div>
							<a href="javascript:void(0);" data-ui="right" class="icon">
								<i class="icon-chevron-right"></i>
							</a>
						</div>
					</div>
				</script>
				<script type="text/x-kendo-template" id="month-content">
					<span# if($.inArray(kendo.toString(data.date, "dd.MM.yyyy"), CALENDAR.events_dates) != -1){ # class="event"# } #>#=data.value#</span>
				</script>
			</div>
		</div>
		
		<div data-uiBox="list" class="mt15">
			<script type="text/x-kendo-template" id="row_template">
				<div>
					<div class="fwbold">
						# var __happenAt = kendo.parseDate(happen_at) #
						<div>#=kendo.toString(__happenAt, "dd.MM")#</div>
						<div style="color: \#A7A7A7">#=kendo.toString(__happenAt, "HH:mm")#</div>
					</div>
					<div>/</div>
					<div>
						<div>#=title.<?=Router::getLang()?>#</div>
					</div>
				</div>
			</script>
			<script type="text/x-kendo-template" id="empty">
				<div class="empty">
					<div><?=t("Немає подій")?></div>
				</div>
			</script>
		</div>
		
	</div>
	
</div>
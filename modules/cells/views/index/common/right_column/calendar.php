<div data-uiBox="calendar">
	
	<script id="data">(<?=json_encode(array(
		"events_dates" => array("23.07.2014")
	))?>);</script>
	
	<header>
		<table width="100%" cellspacing="0" cellpadding="0">
			<td>
				<span><?=t("Календар")?></span>
			</td>
			<? if(CellsModel::i()->isMember(UserClass::i()->getId())){ ?>
				<td class="taright">
					<input type="button" id="add_event" value="<?=t("Додати подію")?>" class="button" />
				</td>
			<? } ?>
		</table>
	</header>
	
	<section>
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
		
	</section>
	
</div>
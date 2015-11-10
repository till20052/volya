<div ui-window="admin.trainings.members" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Учасники")?></h2>
	</div>
	
	<div class="mt10">
		<table id="members_list">
			<script type="text/x-kendo-template">
				<div style="padding:0 10px;line-height:normal">
					#=id#
				</div>
			</script>
			<script type="text/x-kendo-template">
				<div style="padding:0 10px;line-height:normal">
					#=user_name#
				</div>
			</script>
			<script type="text/x-kendo-template">
				<div class="p5 pl20">
					# if(status == 0){ #
						<div>
							<a href="javascript:void(0);" ui="connect" data-id="#=id#" class="icon">
								<i class="icon-ok"></i>
								<span><?=t("Приєднати")?></span>
							</a>
						</div>
						<div>
							<a href="javascript:void(0);" ui="remove" data-id="#=id#" class="icon">
								<i class="icon-remove"></i>
								<span><?=t("Відхилити")?></span>
							</a>
						</div>
					# }else if(status == 1) { #
						<div class="icon" style="color:green">
							<i class="icon-ok"></i>
							<span><?=t("Приєднаний")?></span>
						</div>
						<div>
							<a href="javascript:void(0);" ui="remove" data-id="#=id#" class="icon">
								<i class="icon-remove"></i>
								<span><?=t("Відхилити")?></span>
							</a>
						</div>
					# }else if(status == -1) { #
						<div>
							<span class="icon" style="color:red">
								<i class="icon-remove"></i>
								<span><?=t("Відхилений")?></span>
							</span>
						</div>
					# } #
				</div>
			</script>
		</table>
	</div>
	
</div>
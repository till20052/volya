<div ui-window="admin.mailer.recipients" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Отримувачi")?></h2>
	</div>
	
	<div class="mt10">
		<table id="recipients">
			<script type="text/x-kendo-template">
				<div style="padding:5px 10px;line-height:normal">
					#=id#
				</div>
			</script>
			<script type="text/x-kendo-template">
				<div style="padding:5px 10px;line-height:normal">
					#=value#
				</div>
			</script>
		</table>
	</div>
	
</div>
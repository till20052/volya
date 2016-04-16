<div style="width: 400px; height: 450px;">

	<div data-uiView="images">
		<div data-uiBox="list">
			<script type="text/x-kendo-template">
				<div data-hash="#=hash#" style="background-image: url('/s/img/thumb/160x120/#=hash#')">
					<a data-action="delete" href="javascript:void(0);" class="icon">
						<i class="icon-remove"></i>
					</a>
				</div>
			</script>
			<div></div>
		</div>
		<div data-uiBox="uploader" class="mt5">
			<a href="javascript:void(0);" class="v-button v-button-blue">
				<input type="file" name="file" multiple="true" style="opacity: 0" />
				<?=t("Завантажити фото")?>
			</a>
		</div>

		<a class="v-button" ng-click="getImages()">Get Images</a>
	</div>

</div>
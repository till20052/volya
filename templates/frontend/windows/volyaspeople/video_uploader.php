<div ui-window="volyaspeople.video_uploader" style="width: 450px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Вставте посилання на відео з YouTube")?></h2>
	</div>
	
	<div class="mt15 fs14 tacenter">
		<div>
			<input type="text" id="link" class="textbox" style="width: 100%" />
		</div>
		
		<div data-uiBox="preview" class="mt15">
			<div class="preview" style="height: 30px; background-image: url('/kendo/styles/Uniform/loading_2x.gif'); background-size: contain"></div>
		</div>
		
		<div class="mt15">
			<a href="javascript:void(0);" class="v-button v-button-blue"><?=t("Ок")?></a>
		</div>
	</div>
	
</div>
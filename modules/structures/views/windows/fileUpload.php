<div style="width: 600px">

	<md-dialog aria-label="Завантаження документу" ng-cloak>

		<md-toolbar>
	      	<div class="md-toolbar-tools">
	        	<h2>Завантаження документу</h2>
	        	<span flex></span>
	        	<md-button class="md-icon-button" ng-click="cancel()">
	          		<md-icon aria-label="Close dialog">X</md-icon>
	        	</md-button>
	      </div>
	    </md-toolbar>

		<md-dialog-content>

			<div class="md-dialog-content">

      			<div style="height: 330px;">

					<md-content>
					    <form name="projectForm">

					    	<md-input-container class="md-block">
						    	<label><?=t("Назва документу")?></label>
						        <input required="" md-maxlength="30" name="title" ng-model="document.title">
						        <div ng-messages="projectForm.title.$error">
						        	<div ng-message="required">Це поле обов'язкове</div>
						        	<div ng-message="md-maxlength">Назва документу не може бути довшою за 30 символів</div>
						        </div>
						    </md-input-container>

					     	<md-input-container class="md-block">
					      		<label><?=t("Опис")?></label>
					        	<input md-maxlength="150" md-no-asterisk name="description" ng-model="project.description">

					        	<div ng-messages="projectForm.description.$error">
					        		<div ng-message="md-maxlength">Назва документу не може бути довшою за 150 символів</div>
					        	</div>
					      	</md-input-container>

					      	<md-input-container class="md-block">
				            	<label>Категорія</label>

				            	<md-select ng-model="category" ng-required="true">
				              		<md-option ng-repeat="category in dc" value="{{category.id}}">
				                		{{category.title}}
				              		</md-option>
				            	</md-select>
				          	</md-input-container>

					    </form>
					</md-content>

					<div data-uiView="images">

						<div class="filesList" style="width: 350px; float: left;">

							<div ng-repeat="file in files" class="avatar avatar-2x fleft" style="background-image:url('/s/img/thumb/ai/{{file.hash}}')">
							</div>
							

							<md-fab-speed-dial>
								<md-fab-trigger>
									<md-button aria-label="menu" class="md-fab md-warn">
<!--										<md-icon md-svg-src="img/icons/menu.svg"></md-icon>-->
									</md-button>
								</md-fab-trigger>

								<md-fab-actions>
									<md-button aria-label="Twitter" class="md-fab md-raised md-mini">
<!--										<md-icon md-svg-src="img/icons/twitter.svg" aria-label="Twitter"></md-icon>-->
									</md-button>
									<md-button aria-label="Facebook" class="md-fab md-raised md-mini">
<!--										<md-icon md-svg-src="img/icons/facebook.svg" aria-label="Facebook"></md-icon>-->
									</md-button>
									<md-button aria-label="Google Hangout" class="md-fab md-raised md-mini">
<!--										<md-icon md-svg-src="img/icons/hangout.svg" aria-label="Google Hangout"></md-icon>-->
									</md-button>
								</md-fab-actions>
							</md-fab-speed-dial>



						</div>

						<div data-uiBox="uploader" class="mt5">

					      	<md-button class="md-fab md-primary" aria-label="Profile" ng-click="openFileBrowser()">
					            <i class="fa fa-file-image-o fa-2x" style="top: 4px; position: relative;" aria-hidden="true"></i>
					        </md-button>

							<input id="fileInput" type="file" name="file" multiple="true" style="display: none" />
						</div>
					</div>

				</div>
			</div>

		</md-dialog-content>

	    <md-dialog-actions layout="row">
	      	<md-button class="md-raised md-primary" ng-click="save()">
	       		Зберегти
	      	</md-button>
	      	<md-button ng-click="cancel()">
	      		Відміна
	      	</md-button>
		</md-dialog-actions>

	</md-dialog>

</div>
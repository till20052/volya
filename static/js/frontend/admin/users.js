$(document).ready(function()
{
	var __section = $("body>section");
	var DATA = eval($("script#data", __section).text());
	
	var __formUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.users.form']"));
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
			__uiForm.data({
				id: $(__uiWindow.element).attr("data-id"),
				type: __typeUiSelect.value(),
				credential_level: __credentialLevelUiSelect.value()
			});
		}).afterSend(function(response)
		{
			if( ! response.success)
			{
				response.errors.forEach(function(item){
					var __selector = "";
					switch(item)
					{
						case "invalid login":
							__selector = "input#login";
							break;
						case "invalid password":
							__selector = "input#password, input#confirm_password";
							break;
					}
					if(__selector != "")
					{
						$(__selector, __uiWindow.element).css("borderColor", "red");
						setTimeout(function(){
							$(__selector, __uiWindow.element).css("borderColor", "");
						}, 1000);
					}
				});
				return;
			}
			
			if( ! (__uiForm.data("id") > 0))
				__listUiTable.dataSource.insert(0, response.item);
			else
			{
				var __dataItem = __listUiTable.dataSource.get(response.item.id);
				for(var __field in response.item)
					__dataItem.set(__field, response.item[__field]);
			}
			
			__uiWindow.close();
		});
		
		var __typeUiSelect = $("select[data-ui='type']").kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		__uiWindow.ui("typeUiSelect", __typeUiSelect);
		
		var __credentialLevelUiSelect = $("select[data-ui='credential_level']").kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		__uiWindow.ui("credentialLevelUiSelect", __credentialLevelUiSelect);
		
		$("a#save", __uiWindow.element).click(function()
		{
			__uiForm.send();
		});
		
		$("a#cancel", __uiWindow.element).click(function()
		{
			__uiWindow.close();
		});
		
		return __uiWindow;
	})();
	
	var __confirmUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.users.confirm']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			$.post("/admin/users/j_delete", {
				id: $(__uiWindow.element).attr("data-id")
			}, function(response)
			{
				if( ! response.success)
					return;
				
				__listUiTable.dataSource.remove(__listUiTable.dataSource.get($(__uiWindow.element).attr("data-id")));
				
				__uiWindow.close();
			}, "json");
		});
		
		$("a#no", __uiWindow.element).click(function()
		{
			__uiWindow.close();
		});
		
		return __uiWindow;
	})();
	
	var __finderUiWindow = (function(){
		var __uiWindow = new Window($("div[ui-window='admin.users.finder']"));
		
		$("input#first_name", __uiWindow.element).val(
			typeof DATA.filter.first_name != "undefined"
			? DATA.filter.first_name
			: ""
		);

		$("input#last_name", __uiWindow.element).val(
			typeof DATA.filter.last_name != "undefined"
			? DATA.filter.last_name
			: ""
		);
		
		var __typeUiSelect = $("select[data-ui='type']", __uiWindow.element).kendoDropDownList({
			value: typeof DATA.filter.type != "undefined" ? DATA.filter.type : 0
		}).data("kendoDropDownList");
		
		var __employmentScopeUiSelect = $("select[data-ui='employment_scope']", __uiWindow.element).kendoDropDownList({
			value: typeof DATA.filter.employment_scope != "undefined" ? DATA.filter.employment_scope : 0
		}).data("kendoDropDownList");
		
		var __isArtificialUiSelect = $("select[data-ui='is_artificial']", __uiWindow.element).kendoDropDownList({
			value: typeof DATA.filter.is_artificial != "undefined" ? DATA.filter.is_artificial : 2
		}).data("kendoDropDownList");
		
		var __allFieldsAreFilledUiSelect = $("select[data-ui='all_fields_are_filled']", __uiWindow.element).kendoDropDownList({
			value: typeof DATA.filter.all_fields_are_filled != "undefined" ? DATA.filter.all_fields_are_filled : 0
		}).data("kendoDropDownList");
		
		var __regionUiSelect = (function(element){
			return $(element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: ({
					data: ([{id: 0, title: "\u2014"}]).concat(DATA.regions),
					scheme: {model: {id: "id"}}
				}),
				value: typeof DATA.filter.rid != "undefined" ? DATA.filter.rid : 0,
				change: (function(event){
					var __regionId = event.sender.value(),
						__url = "/api/geo/j_get_cities_and_areas",
						__postData = ({
							country_id: 2,
							region_id: __regionId
						});
						
					
					([__cityUiSelect, __areaUiSelect, __cityAreaUiSelect]).forEach(function(sender){
						sender.dataSource.data([{id: 0, title: "\u2014"}]);
						sender.value(0);
						
//						if( ! (__regionId > 0)){ // || ! ($.inArray(__regionId, ["8000000000", "8500000000"]) > -1)
							$("tr[data-ui='"+$(sender.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").hide();
							$("tr[data-ui='"+$(sender.element).attr("data-ui")+"']", __uiWindow.element).hide();
							sender.options.change({sender: sender});
//						}
					});
					
					if( ! (__regionId > 0))
						return;
					
					if( ! ($.inArray(__regionId, ["8000000000", "8500000000"]) > -1)){
						([__cityUiSelect, __areaUiSelect]).forEach(function(sender){
							$("tr[data-ui='"+$(sender.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").show();
							$("tr[data-ui='"+$(sender.element).attr("data-ui")+"']", __uiWindow.element).show();
							$("div[data-uiCover='"+$(sender.element).attr("data-ui")+"']", __uiWindow.element).show();
						});
					}
					else
					{
						$("tr[data-ui='"+$(__cityAreaUiSelect.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").show();
						$("tr[data-ui='"+$(__cityAreaUiSelect.element).attr("data-ui")+"']", __uiWindow.element).show();
						__url = "/api/geo/j_get_city_areas";
						delete __postData.region_id;
						__postData["city_id"] = __regionId;
					}
					
					$.post(__url, __postData, function(response){
						if( ! response.success)
							return;
						
						console.log(response);
						
						if( ! ($.inArray(__regionId, ["8000000000", "8500000000"]) > -1)){
							([__cityUiSelect, __areaUiSelect]).forEach(function(sender){
								$("div[data-uiCover='"+$(sender.element).attr("data-ui")+"']", __uiWindow.element).hide();
								sender.dataSource.data(([{id: 0, title: "\u2014"}]).concat(response[(function(dataUi){return (new Object({city: "cities", area: "areas"}))[dataUi];}($(sender.element).attr("data-ui")))]));
								sender.value(0);

								// ????????
								sender.options.change({sender: sender});
							});
						}
						else
						{
							__cityAreaUiSelect.dataSource.data(([{id: 0, title: "\u2014"}]).concat(response.city_areas));
							__cityAreaUiSelect.value(0);

							// ????????
							__cityAreaUiSelect.options.change({sender: __cityAreaUiSelect});
						}
						
//						if(DATA.filter.aid > 0)
//						{
//							__areaUiSelect.value(DATA.filter.aid);
//							__areaUiSelect.options.change({sender: __areaUiSelect});
//							DATA.filter.aid = 0;
//						}
					}, "json");
				})
			}).data("kendoDropDownList");
		}($("select[data-ui='region']", __uiWindow.element)));
		
		var __cityUiSelect = (function(element){
			return $(element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: ({
					data: [],
					scheme: {model: {id: "id"}}
				}),
				change: (function(event){
					var __cityId = event.sender.value(),
						__cityArea = ({
							show: (function(){
								$("tr[data-ui='"+$(__cityAreaUiSelect.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").show();
								$("tr[data-ui='"+$(__cityAreaUiSelect.element).attr("data-ui")+"']", __uiWindow.element).show();
							}),
							hide: (function(){
								$("tr[data-ui='"+$(__cityAreaUiSelect.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").hide();
								$("tr[data-ui='"+$(__cityAreaUiSelect.element).attr("data-ui")+"']", __uiWindow.element).hide();
							})
						});
					
					__cityAreaUiSelect.dataSource.data([{id: 0, title: "\u2014"}]);
					__cityAreaUiSelect.value(0);
					
					if( ! (__cityId > 0)){
						if(__regionUiSelect.value() > 0 && ! ($.inArray(__regionUiSelect.value(), ["8000000000", "8500000000"]) > -1)){
							$("tr[data-ui='"+$(__areaUiSelect.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").show();
							$("tr[data-ui='"+$(__areaUiSelect.element).attr("data-ui")+"']", __uiWindow.element).show();
							__areaUiSelect.value(0);
						}
						return __cityArea.hide();
					}
					
					__areaUiSelect.value(0);
					$("tr[data-ui='"+$(__areaUiSelect.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").hide();
					$("tr[data-ui='"+$(__areaUiSelect.element).attr("data-ui")+"']", __uiWindow.element).hide();
					
					$.post("/api/geo/j_get_city_areas", {
						country_id: 2,
						city_id: __cityId
					}, function(response){
						if(
								! response.success
								|| ! (response.city_areas.length > 0)
						)
							return __cityArea.hide();
						
						__cityArea.show();
						
						__cityAreaUiSelect.dataSource.data(([{id: 0, title: "\u2014"}]).concat(response.city_areas));
						__cityAreaUiSelect.value(0);
						
//						if(DATA.filter.aid > 0)
//						{
//							__areaUiSelect.value(DATA.filter.aid);
//							__areaUiSelect.options.change({sender: __areaUiSelect});
//							DATA.filter.aid = 0;
//						}
					}, "json");
				})
			}).data("kendoDropDownList");
		}($("select[data-ui='city']", __uiWindow.element)));
		
		var __areaUiSelect = (function(element){
			return $(element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: ({
					data: [],
					scheme: {model: {id: "id"}}
				}),
				change: (function(event){
					var __areaId = event.sender.value(),
						__areaCity = ({
							show: (function(){
								$("tr[data-ui='"+$(__areaCityUiSelect.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").show();
								$("tr[data-ui='"+$(__areaCityUiSelect.element).attr("data-ui")+"']", __uiWindow.element).show();
							}),
							hide: (function(){
								$("tr[data-ui='"+$(__areaCityUiSelect.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").hide();
								$("tr[data-ui='"+$(__areaCityUiSelect.element).attr("data-ui")+"']", __uiWindow.element).hide();
							})
						});
					
					__areaCityUiSelect.dataSource.data([{id: 0, title: "\u2014"}]);
					__areaCityUiSelect.value(0);
					
					if( ! (__areaId > 0)){
						if(__regionUiSelect.value() > 0 && ! ($.inArray(__regionUiSelect.value(), ["8000000000", "8500000000"]) > -1)){
							$("tr[data-ui='"+$(__cityUiSelect.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").show();
							$("tr[data-ui='"+$(__cityUiSelect.element).attr("data-ui")+"']", __uiWindow.element).show();
							__cityUiSelect.value(0);
						}
						return __areaCity.hide();
					}
					
					__cityUiSelect.value(0);
					$("tr[data-ui='"+$(__cityUiSelect.element).attr("data-ui")+"']", __uiWindow.element).prev("tr").hide();
					$("tr[data-ui='"+$(__cityUiSelect.element).attr("data-ui")+"']", __uiWindow.element).hide();
					
					$.post("/api/geo/j_get_area_cities", {
						country_id: 2,
						area_id: __areaId
					}, function(response){
						if(
								! response.success
								|| ! (response.area_cities.length > 0)
						)
							return __areaCity.hide();
						
						__areaCity.show();
						
						__areaCityUiSelect.dataSource.data(([{id: 0, title: "\u2014"}]).concat(response.area_cities));
						__areaCityUiSelect.value(0);
						
//						if(DATA.filter.aid > 0)
//						{
//							__areaUiSelect.value(DATA.filter.aid);
//							__areaUiSelect.options.change({sender: __areaUiSelect});
//							DATA.filter.aid = 0;
//						}
					}, "json");
				})
			}).data("kendoDropDownList");
		}($("select[data-ui='area']", __uiWindow.element)));
		
		var __areaCityUiSelect = (function(element){
			return $(element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: ({
					data: [],
					scheme: ({model: ({id: "id"})})
				})
			}).data("kendoDropDownList")
		}($("select[data-ui='area_city']", __uiWindow.element)));
		
		var __cityAreaUiSelect = (function(element){
			return $(element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: ({
					data: [],
					scheme: ({model: ({id: "id"})})
				}),
				change: (function(){})
			}).data("kendoDropDownList")
		}($("select[data-ui='city_area']", __uiWindow.element)));
		
		__regionUiSelect.options.change({sender: __regionUiSelect});
		
		if(DATA.filter.is_artificial == 1)
			$("input[name^='is_artificial'][value=1]", __uiWindow.element).attr("checked", 1);
		
		$("input[data-ui='search']", __uiWindow.element).click(function(){
			var __href = "?";

			__href += "type="+__typeUiSelect.value()+"&";

			if(__cityAreaUiSelect.value() != 0)
				__href += "geo="+__cityAreaUiSelect.value()+"&";
			else if(__areaCityUiSelect.value() != 0)
				__href += "geo="+__areaCityUiSelect.value()+"&";
			else if(__areaUiSelect.value() != 0)
				__href += "geo="+__areaUiSelect.value()+"&";
			else if(__cityUiSelect.value() != 0)
				__href += "geo="+__cityUiSelect.value()+"&";
			else if(__regionUiSelect.value() != 0)
				__href += "geo="+__regionUiSelect.value()+"&";

			if(__employmentScopeUiSelect.value() > 0)
				__href += "es="+__employmentScopeUiSelect.value()+"&";
			
			if(__allFieldsAreFilledUiSelect.value() > 0)
				__href += "all_fields_are_filled="+__allFieldsAreFilledUiSelect.value()+"&";
			
			if(__isArtificialUiSelect.value() < 2)
				__href += "is_artificial="+__isArtificialUiSelect.value()+"&";
			
			if($("input#first_name", __uiWindow.element).val() != "")
				__href += "first_name="+$("input#first_name", __uiWindow.element).val()+"&";
			
			if($("input#last_name", __uiWindow.element).val() != "")
				__href += "last_name="+$("input#last_name", __uiWindow.element).val()+"&";

			window.location.href = __href.substr(0, __href.length - 1);
		});
		
		$("input[data-ui='cancel']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});
		
		return __uiWindow;
	}());
	
	var __viewerUiWindow = (function(){
		var __uiWindow = new Window($("div[ui-window='admin.users.viewer']"));
		
		var __uiTabStrip = $("div[data-uiTabStrip='viewer']", __uiWindow.element).kendoTabStrip({
			animation : false
		}).data("kendoTabStrip");
		__uiWindow.ui("tabStrip", __uiTabStrip);
		
		return __uiWindow;
	}());
	
	var __scansViewerUiWindow = (function(){
		var __uiWindow = (new Window($("div[ui-window='admin.users.scans_viewer']"))).afterOpen(function(){
			__dataArray = eval($(__data).text());
			
			$("img#image", __uiWindow.element).attr("src", "/s/img/thumb/ap/"+__dataArray[parseInt($(__data).attr("ui-dataCurrent"))]["file"]).load(function(){
				__uiWindow.checkPosition();
			});
		}).afterClose(function(){
			__viewerUiWindow.open();
		});
		
		var __data = $("div#data", __uiWindow.element);
		var __dataArray = new Array();
		
		$("i#prevImage").click(function(){
			if( $(__data).attr("ui-dataCurrent") == 0 ){
				$("img#image", __uiWindow.element).attr("src", "/s/img/thumb/ap/"+__dataArray[__dataArray.length-1]["file"]);
				$(__data).attr("ui-dataCurrent", __dataArray.length - 1);
			}else {
				$("img#image", __uiWindow.element).attr("src", "/s/img/thumb/ap/"+__dataArray[parseInt($(__data).attr("ui-dataCurrent"))-1]["file"]);
				$(__data).attr("ui-dataCurrent", parseInt($(__data).attr("ui-dataCurrent"))-1);
			};
		});

		$("i#nextImage").click(function(){
			if( $(__data).attr("ui-dataCurrent") == __dataArray.length-1 ){
				$("img#image", __uiWindow.element).attr("src", "/s/img/thumb/ap/"+__dataArray[0]["file"]);
				$(__data).attr("ui-dataCurrent", 0);
				return false;
			}else {
				$("img#image", __uiWindow.element).attr("src", "/s/img/thumb/ap/"+__dataArray[parseInt($(__data).attr("ui-dataCurrent"))+1]["file"]);
				$(__data).attr("ui-dataCurrent", parseInt($(__data).attr("ui-dataCurrent"))+1);
				return false;
			};
		});
			
		return __uiWindow;
	}());
	
	var __emailTemplatesUiWindow = (function(){
		var __uiWindow = new Window($("div[ui-window='admin.users.email_templates']"));
		
		var __templatesUiSelect = $("select[data-ui='temapltes']", __uiWindow.element).kendoDropDownList({
			dataValueField: "symlink",
			dataTextField: "subject.ua",
			valueTemplate: "#=data.id#. #=data.subject.ua#",
			template: "#=data.id#. #=data.subject.ua#"
		}).data("kendoDropDownList");
		__uiWindow.ui("templatesUiSelect", __templatesUiSelect);
		
		$("input#send", __uiWindow.element).click(function(){
			var __data = eval($("script#data", __section).text());
			
			$.post("/admin/users/j_send_email", $.extend({}, {
				symlink: __templatesUiSelect.value()
			}, __data.filter), function(){
				__uiWindow.close();
			}, "json");
		});
		
		$("input#cancel", __uiWindow.element).click(function(){
			__uiWindow.close();
		});
		
		return __uiWindow;
	}());
	
	$("a#add", __section).click(function()
	{
		$(__formUiWindow.element).attr("data-id", 0);
		
		$("input#first_name, input#last_name, input#middle_name", __formUiWindow.element).val("");
		$("input#login, input#password, input#confirm_password", __formUiWindow.element).val("");
		
		__formUiWindow.ui("typeUiSelect").value(1);
		__formUiWindow.ui("credentialLevelUiSelect").value(1);
		
		__formUiWindow.open();
	});
	
	$("a[data-ui='open_finder']", __section).click(function(){
		__finderUiWindow.open();
	});
	
	$("a[data-ui='open_email_templates']", __section).click(function(){
		$.post("/admin/users/j_get_email_templates", function(response){
			if( ! response.success)
				return;
			
			__emailTemplatesUiWindow.open();
			__emailTemplatesUiWindow.ui("templatesUiSelect").dataSource.data(response.list);
		}, "json");
	});
	
	var __listUiTable = (function()
	{
		$("table#list>script", __section).each(function(i)
		{
			DATA["table#list"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#list", __section).kendoGrid($.extend(DATA["table#list"], {
			dataBound: (function(e)
			{
				$("input[type='checkbox'][ui='is_active']", e.sender.tbody).click(function()
				{
					$.post("/admin/users/j_activate", {
						id: $(this).attr("data-id"),
						state: $(this).attr("checked") == "checked" ? 1 : 0
					});
				});
				
				$("a[ui='view']", e.sender.tbody).click(function()
				{
					$.post("/admin/users/j_get_full_info", {
						id: $(this).attr("data-id")
					}, function(response)
					{
						if( ! response.success)
							return;
						
						var __userInfo = response.user_info;
						var __userContacts = response.user_contacts;
						var __userDocs = response.user_docs;
						var __userVerification = response.verification;
						
						__viewerUiWindow.ui("tabStrip").select(0);
						
						$("tr#verificate", __viewerUiWindow.element).show();
						$("span#verificate_at", __viewerUiWindow.element).html("");
						$("span#user_verificate", __viewerUiWindow.element).html("");
						$("tr.varificateData").hide();
						
						$(__viewerUiWindow.element).attr("data-id", __userInfo.id);
						
						$("div#avatar").empty();
						if(__userInfo.avatar != "")
						{
							$("div#avatar").css({
								backgroundImage: "url('/s/img/thumb/ag/"+__userInfo.avatar+"')"
							});
						}
						else
						{
							$("div#avatar").css({
								backgroundImage: ""
							}).append($("<i class=\"icon-user\" />"));
						}
						
						$("span#first_name", __viewerUiWindow.element).html(__userInfo.first_name);
						$("span#last_name", __viewerUiWindow.element).html(__userInfo.last_name);
						$("span#middle_name", __viewerUiWindow.element).html(__userInfo.middle_name);
						
						$("span#education", __viewerUiWindow.element).html(__userInfo.education);
						$("span#jobs", __viewerUiWindow.element).html(__userInfo.jobs);
						$("span#social_activity", __viewerUiWindow.element).html(__userInfo.social_activity);
						$("span#political_activity", __viewerUiWindow.element).html(__userInfo.political_activity);
						
						if( __userInfo.birthday_day > 0 )
						{
							$("span#birthday_day", __viewerUiWindow.element).html(__userInfo.birthday_day);
							$("span#birthday_month", __viewerUiWindow.element).html(__userInfo.birthday_month);
							$("span#birthday_year", __viewerUiWindow.element).html(__userInfo.birthday_year);
						}
						
						$("span#city", __viewerUiWindow.element).html(__userInfo.city_name);
						$("span#region", __viewerUiWindow.element).html(__userInfo.region_name);
						$("span#country", __viewerUiWindow.element).html(__userInfo.country_name);
						
						if( __userInfo.street != '' )
							$("span#address", __viewerUiWindow.element).html(__userInfo.street+' '+__userInfo.house_number+", "+__userInfo.apartment_number);
						
						if( __userVerification.user_verifier_id ){
							$("tr.varificateData").show();
							$("tr#verificate", __viewerUiWindow.element).hide();
							$("span#verificate_at", __viewerUiWindow.element).html( __userVerification.verified_at );
							$("span#user_verificate", __viewerUiWindow.element).html( __userVerification.user_verifier );
						}
						else
							$("tr.varificateData").hide();
						
						$("td#emails", __viewerUiWindow.element).html("");
						__userContacts.emails.forEach(function(email){
							var __span = $("<span />");
							
							__span.html(email.value).addClass("fwbold");
							$("td#emails", __viewerUiWindow.element).append(__span).append("<br />");
						});
						
						$("td#phones", __viewerUiWindow.element).html("");
						__userContacts.phones.forEach(function(phone){
							var __span = $("<span />");
							
							__span.html(phone.value).addClass("fwbold");
							$("td#phones", __viewerUiWindow.element).append(__span).append("<br />");
						});
						
						$("div.disallow", __viewerUiWindow.element).hide();
						$("div.allow", __viewerUiWindow.element).hide();
						
						if( __userInfo.was_allowed_to_use_pd == 1 )
							$("div.allow", __viewerUiWindow.element).show();
						else
							$("div.disallow", __viewerUiWindow.element).show();
						
						$("div.scanPreview", __viewerUiWindow.element).css("backgroundImage", "url('/img/no_image.jpg')");
						
						$("div#data", __scansViewerUiWindow.element).text( JSON.stringify(__userDocs) );
						
						__userDocs.forEach(function(doc, i){
							if( doc.file != "false" )
								$("div#"+doc.type, __viewerUiWindow.element).css("backgroundImage", "url('/s/img/thumb/ag/"+doc.file+"')").next("div").click(function(){
									$("div#data", __scansViewerUiWindow.element).attr("ui-dataCurrent", i);
									$("img#image", __scansViewerUiWindow.element).attr("src", "");
									__scansViewerUiWindow.open();
								});
						});
						
						__viewerUiWindow.open();
					}, "json");
				});
				
				$("a#verify", __viewerUiWindow.element).click(function(){
					$.post("/admin/users/j_verify",
					{
						id: $(__viewerUiWindow.element).attr("data-id")
					}, function(response){
						if( ! response.success)
							return;

						__listUiTable.dataSource.get(response.verification.user_id).set("is_verified", 1);
							
						$("span#verificate_at", __viewerUiWindow.element).html( response.verification.verified_at );
						$("span#user_verificate", __viewerUiWindow.element).html( response.verification.user_verified );

						$("tr#verificate", __viewerUiWindow.element).hide(500);
						$("tr.varificateData").delay(500).show(500);
					}, "json");
				});
				
				$("a[ui='edit']", e.sender.tbody).click(function()
				{
					$.post("/admin/users/j_get_item", {
						id: $(this).attr("data-id")
					}, function(response)
					{
						if( ! response.success)
							return;
						
						var __item = response.item
						
						$(__formUiWindow.element).attr("data-id", __item.id);
						
						$("input#first_name", __formUiWindow.element).val(__item.first_name);
						$("input#last_name", __formUiWindow.element).val(__item.last_name);
						$("input#middle_name", __formUiWindow.element).val(__item.middle_name);
						$("input#login", __formUiWindow.element).val(__item.login);
						$("input#password, input#confirm_password", __formUiWindow.element).val("");
						__formUiWindow.ui("typeUiSelect").value(__item.type);
						__formUiWindow.ui("credentialLevelUiSelect").value(__item.credential_level);
						
						__formUiWindow.open();
					}, "json");
				});
				
				$("a[ui='remove']", e.sender.tbody).click(function()
				{
					$(__confirmUiWindow.element).attr("data-id", $(this).attr("data-id"));
					__confirmUiWindow.open();
				});
			})
		}));
		
		return $("table#list", __section).data("kendoGrid");
	})();
	
	$("div.scansZoom", __viewerUiWindow.element).hover(function(){
		$(this).animate({
			opacity: 1
		}, 100);
	}, function(){
		$(this).stop().animate({
			opacity: 0
		}, 100);
	});
	
});

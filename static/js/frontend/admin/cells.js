$(document).ready(function()
{
	var __section = $("body>section");
	var __data = eval($("script#data", __section).text());
	
	var __formUiWindow = (function()
	{
		var __uiWindow = (new Window($("div[ui-window='admin.cells.form']")));
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
//			__uiForm.data({
//				id: $(__uiWindow.element).attr("data-id"),
//				title: __i18n.value("title"),
//				text: __i18n.value("text")
//			});
		}).afterSend(function(response)
		{
			if( ! response.success)
				return;
			
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
		
		$("a#cancel", __uiWindow.element).click(function()
		{
			__uiWindow.close();
		});
		
		return __uiWindow;
	})();
	
	var __confirmUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.cells.confirm']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			$.post("/admin/cells/j_delete", {
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
	
	var __viewerUiWindow = (function(){
		var __uiWindow = new Window($("div[ui-window='admin.cells.viewer']"));
		
		var __uiTabStrip = $("div[data-uiTabStrip='viewer']", __uiWindow.element).kendoTabStrip({
			animation : false
		}).data("kendoTabStrip");
		__uiWindow.ui("tabStrip", __uiTabStrip);
		
		return __uiWindow;
	}());
	
	var __scansViewerUiWindow = (function(){
		var __uiWindow = (new Window($("div[ui-window='admin.cells.scans_viewer']"))).afterOpen(function(){
			__dataArray = eval($(__data).text());
			
			$("img#image", __uiWindow.element).attr("src", "/s/img/thumb/ap/"+__dataArray[parseInt($(__data).attr("ui-dataCurrent"))]["hash"]).load(function(){
				__uiWindow.checkPosition();
			});
		}).afterClose(function(){
			__viewerUiWindow.open();
		});
		
		var __data = $("div#data", __uiWindow.element);
		var __dataArray = new Array();
		
		$("i#prevImage").click(function(){
			if( $(__data).attr("ui-dataCurrent") == 0 ){
				$("img#image", __uiWindow.element).attr("src", "/s/img/thumb/ap/"+__dataArray[__dataArray.length-1]["hash"]);
				$(__data).attr("ui-dataCurrent", __dataArray.length - 1);
			}else {
				$("img#image", __uiWindow.element).attr("src", "/s/img/thumb/ap/"+__dataArray[parseInt($(__data).attr("ui-dataCurrent"))-1]["hash"]);
				$(__data).attr("ui-dataCurrent", parseInt($(__data).attr("ui-dataCurrent"))-1);
			};
		});

		$("i#nextImage").click(function(){
			if( $(__data).attr("ui-dataCurrent") == __dataArray.length-1 ){
				$("img#image", __uiWindow.element).attr("src", "/s/img/thumb/ap/"+__dataArray[0]["hash"]);
				$(__data).attr("ui-dataCurrent", 0);
				return false;
			}else {
				$("img#image", __uiWindow.element).attr("src", "/s/img/thumb/ap/"+__dataArray[parseInt($(__data).attr("ui-dataCurrent"))+1]["hash"]);
				$(__data).attr("ui-dataCurrent", parseInt($(__data).attr("ui-dataCurrent"))+1);
				return false;
			};
		});
			
		return __uiWindow;
	}());
	
	var __listUiTable = (function()
	{
		$("table#list>script", __section).each(function(i)
		{
			__data["table#list"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#list", __section).kendoGrid($.extend({}, __data["table#list"], {
			dataBound: (function(e)
			{
				$("a[ui='view']", e.sender.tbody).click(function()
				{
					$.post("/admin/cells/j_get_item", {
						id: $(this).attr("data-id")
					}, function(response)
					{
						if( ! response.success)
							return;
						
						$(__viewerUiWindow.element).attr("data-id", response.item.id);
						
						$("span#region_name", __viewerUiWindow.element).html(response.item.region_name);
						$("span#city_name", __viewerUiWindow.element).html(response.item.city_name);
						$("span#area_in_city", __viewerUiWindow.element).html(response.item.area_in_city);
						$("span#roep_plot_number", __viewerUiWindow.element).html(response.item.roep_plot_number);
						$("span#address", __viewerUiWindow.element).html(response.item.address);
						$("span#created_at", __viewerUiWindow.element).html(response.item.created_at);
						
						$("td#users", __viewerUiWindow.element).html("");
						response.users.forEach(function(user){
							var __span = $("<span />");
							
							__span.html(user).addClass("fwbold");
							$("td#users", __viewerUiWindow.element).append(__span).append("<br />");
						});
						
						var scans = response.scans;
						$("div#data", __scansViewerUiWindow.element).text( JSON.stringify(scans) );
						$("div[data-uiBox='scans']", __viewerUiWindow.element).html("");
						
						scans.forEach(function(doc, i){
							if( doc.hash != "false" ){
								var scanDiv = $("<div />")
												.addClass("scan fleft")
												.html($("<div />")
													.addClass("scanPreview")
													.css(
													{
														backgroundImage : "url('/s/img/thumb/ag/"+doc.hash+"')"
													})
												)
												.append(
													$("<div />").addClass("scansZoom")
														.append($("<i />").addClass("icon-mergeshapes"))
															.click(function(){
																$("div#data", __scansViewerUiWindow.element).attr("ui-dataCurrent", i);
																$("img#image", __scansViewerUiWindow.element).attr("src", "");
																__scansViewerUiWindow.open();
															})
												);
								
								if( (i + 1) % 3 != 0 )
									$(scanDiv).addClass("pr5");
								$("div[data-uiBox='scans']", __viewerUiWindow.element).append(scanDiv);
								
							}
						});
						
						$("div[data-uiBox='scans']", __viewerUiWindow.element).append($("<div />").addClass("cboth"));
						
						if( response.verification.user_verifier_id )
						{
							$("tr.varificateData").show();
							$("tr#verificate", __viewerUiWindow.element).hide();
							$("span#verificate_at", __viewerUiWindow.element).html( response.verification.verified_at );
							$("span#user_verificate", __viewerUiWindow.element).html( response.verification.user_verifier );
						}
						else
							$("tr.varificateData").hide();
						
						__viewerUiWindow.open();
					}, "json");
				});
				
				$("a#verify", __viewerUiWindow.element).click(function(){
					$.post("/admin/cells/j_verify",
					{
						id: $(__viewerUiWindow.element).attr("data-id")
					}, function(response){
						if( ! response.success)
							return;

						$("span#verificate_at", __viewerUiWindow.element).html( response.verification.verified_at );
						$("span#user_verificate", __viewerUiWindow.element).html( response.verification.user_verified );

						$("tr#verificate", __viewerUiWindow.element).hide(500);
						$("tr.varificateData").delay(500).show(500);
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
	
	$("div.scansZoom", __viewerUiWindow.element).live({
		mouseenter: function () {
			$(this).animate({
				opacity: 1
			}, 100);
		},
		mouseleave: function () {
			$(this).stop().animate({
				opacity: 0
			}, 100);
		}
	});
});
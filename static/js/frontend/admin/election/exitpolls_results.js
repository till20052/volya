$(document).ready(function(){
	
	var __section = $("body>section>div.section");
	
	var __partyUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		$("a[data-action='save']", __uiWindow.element).click(function(){
			$.post("/admin/election/j_er_save_party", {
				id: $(__uiWindow.element).attr("data-id"),
				name: $("input#name", __uiWindow.element).val()
			}, function(response){
				if(response.success){
					__uiWindow.close();
					__listUiTable.init(response.data);
					return;
				}
				
			}, "json");
		});
		
		$("a[data-action='cancel']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});
		
		return $.extend(__uiWindow, {
			fillDataAndOpenWindow: function(data){
				$(__uiWindow.element).attr("data-id", typeof data.id != "undefined" ? data.id : 0);
				$("input#name", __uiWindow.element).val(typeof data.name != "undefined" ? data.name : "");
				__uiWindow.open();
			}
		});
	})($("div[ui-window='admin.election.exitpolls_results.party_form']"));
	
	var __exitpollUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		$("a[data-action='save']", __uiWindow.element).click(function(){
			$.post("/admin/election/j_er_save_exitpoll", {
				id: $(__uiWindow.element).attr("data-id"),
				name: $("input#name", __uiWindow.element).val()
			}, function(response){
				if(response.success){
					__uiWindow.close();
					__listUiTable.init(response.data);
					return;
				}
				
			}, "json");
		});
		
		$("a[data-action='cancel']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});
		
		return $.extend(__uiWindow, {
			fillDataAndOpenWindow: function(data){
				$(__uiWindow.element).attr("data-id", typeof data.id != "undefined" ? data.id : 0);
				$("input#name", __uiWindow.element).val(typeof data.name != "undefined" ? data.name : "");
				__uiWindow.open();
			}
		});;
	})($("div[ui-window='admin.election.exitpolls_results.exitpoll_form']"));
	
	var __listUiTable = (function(element){
		var __data = eval($(">script", element).text());
		
		var __cleanUp = function(){
			$(">tbody>tr[data-party]", element).remove();
			$(">tbody>tr>td[data-exitpoll]", element).remove();
		};
		
		var __addExitpoll = function(data){
			$("<td />").attr({
				"data-exitpoll": data.id
			}).append($("<div />").append($("<input />").attr({
				type: "checkbox",
				"data-action": "publicate",
				"data-id": data.id,
				checked: data.is_public != 1 ? false : true
			})),
			$("<div />").append($("<a />").attr({
				href: "javascript:void(0);",
				"data-action": "change_exitpoll_name",
				"data-id": data.id
			}).html(data.name != "" ? data.name : "[ untitled ]"))).insertBefore($(">tbody>tr:first-child>td:last-child", element));
			
			$("<td />").attr({
				"data-exitpoll": data.id
			}).insertBefore($(">tbody>tr:last-child>td:last-child", element));
		};
		
		var __addParty = function(data){
			var __tr = $("<tr />").attr({
				"data-party": data.id
			});
			
			$(__tr).append($("<td />").append($("<a />").attr({
				href: "javascript:void(0);",
				"data-action": "change_party_name",
				"data-id": data.id
			}).html(data.name != "" ? data.name : "[ untitled ]")));
			
			__data.exitpolls.forEach(function(item){
				$(__tr).append($("<td />").append($("<a />").attr({
					href: "javascript:void(0);",
					"data-eid": item.id,
					"data-pid": data.id,
					"data-val": __data.results[item.id+"x"+data.id],
					"data-action": "change_value"
				}).html(__data.results[item.id+"x"+data.id]+" %")));
			});
			
			$(__tr).append($("<td />"));
			
			$(__tr).insertBefore($(">tbody>tr:last-child", element));
		};
		
		var __init = function(data){
			__data = data;
			
			__cleanUp();
			
			__data.exitpolls.forEach(function(item){
				__addExitpoll(item);
			});

			__data.parties.forEach(function(item){
				__addParty(item);
			});
		};
		
		var __showValueEditor = function(cell, data){
			$(cell).empty();
			
			$(cell).append($("<input type=\"text\" class=\"textbox\" />").css({
				width: "100%",
				textAlign: "center",
				padding: 0
			}).on("blur keyup", function(e){
				if(e.type != "blur" && (e.type == "keyup" && e.which != 13))
					return;
				
				$.post("/admin/election/j_er_set_value", {
					eid: data.eid,
					pid: data.pid,
					value: $(this).val()
				}, function(response){
					if( ! response.success)
						return;
					
					$(cell).empty();
					
					$(cell).append($("<a />").attr({
						href: "javascript:void(0);",
						"data-eid": data.eid,
						"data-pid": data.pid,
						"data-val": response.value,
						"data-action": "change_value"
					}).html(response.value+" %"));
				}, "json");
			}).val(data.val));
			
			$(">input", cell).focus();
		};
		
		$(element).click(function(event){
			var __element = $(event.srcElement);
			if(typeof $(__element).attr("data-action") == "undefined")
				__element = $($(__element).parents("*[data-action]").eq(0));
			
			switch($(__element).attr("data-action")){
				case "add_party":
					__partyUiWindow.fillDataAndOpenWindow({});
					break;
					
				case "add_exitpoll":
					__exitpollUiWindow.fillDataAndOpenWindow({});
					break;
					
				case "change_value":
					__showValueEditor($($(__element).parents("td").eq(0)), {
						eid: $(__element).attr("data-eid"),
						pid: $(__element).attr("data-pid"),
						val: $(__element).attr("data-val")
					});
					break;
					
				case "change_exitpoll_name":
					__exitpollUiWindow.fillDataAndOpenWindow({
						id: $(__element).attr("data-id"),
						name: $(__element).html()
					});
					break;
					
				case "change_party_name":
					__partyUiWindow.fillDataAndOpenWindow({
						id: $(__element).attr("data-id"),
						name: $(__element).html()
					});
					
				case "publicate":
					$.post("/admin/election/j_er_set_exitpoll_state", {
						id: $(__element).attr("data-id"),
						state: $(__element).attr("checked") != "checked" ? 0 : 1
					}, "json");
					break;
			}
		});
		
		__init(__data);
		
		return ({
			cleanUp: __cleanUp,
			addExitpoll: __addExitpoll,
			addParty: __addParty,
			init: __init
		});
	})($("table[data-ui='list']", __section));
});
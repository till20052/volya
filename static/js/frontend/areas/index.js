$(document).ready(function(){
	
	var div = $("<div />");
	$(div).attr("id", "distincts");
	$("section").append( div );
	
	var div2 = $("<div />");
	$(div2).attr("id", "areas");
	$("section").append( div2 );
	
	$("tr", "#tab1").each(function(p, e){
		
		if( p == 28 )
		{

			$.post( "/areas/j_add_region",
			{
				link : $("a", e).attr("href"),
				name : $("a", e).html()
			}, function(region){

				$("#distincts").html( region.content );

				$("tr", "#distincts #tab3").each(function(p, e){

					$.post( "/areas/j_add_country",
					{
						country : $("td:eq(1)", e).html(),
						plot : $("td:eq(0)", e).html(),
						borders : $("td:eq(2)", e).html(),
						address : $("td:eq(3)", e).html(),
						type : $("td:eq(4)", e).html(),
					}, "json");
				});
			}, "json");
		}
	});
});
$(document).ready(function(){

	var __section = $("body>section>div>div>section");

	(function(ui){
		$("input", ui).change(function(){
			var __number = parseInt($("input#number", ui).val()),
				__income = parseFloat($("input#income", ui).val()),
				__payment = parseFloat($("input#payment", ui).val());

			var __result = __payment - (__income/__number/1176/2*0.15*__income);

			$("span#result", ui).html("0.00");
			$("div[data-ui='messages']>div", ui).hide();

			if(
				! isNaN(__result)
				&& ! (__result < 0)
			){
				$("span#result", ui).html(Math.round(__result*100)/100);
				$("div[data-ui='messages']>div#success", ui).show();
			}
			else if(__result < 0)
				$("div[data-ui='messages']>div#error", ui).show();
		}).change();
	})($("article[data-ui='calc']", __section));

});
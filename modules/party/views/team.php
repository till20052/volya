<? include "common/header.php" ?>

<div class="section mt30">
	
	<div>
		<h1 class="fwbold"><?=t("Команда")?></h1>
	</div>
	
	<div class="mt5">
		<h3>Ще декілька років тому жоден з нас не міг уявити себе в партії, оскільки більшість із нас - люди, відомі та успішні в інших сферах діяльності. Ми пробували творити зміни в журналістиці, бізнесі, громадкській діяльності, але зрозуміли: шлях до змін - це політична діяльність. Саме тому ми об'єдналися, щоби заснувати партію «ВОЛЯ»</h3>
	</div>
	
	<div class="list mt30">
		<? foreach($list as $__item){ ?>
			<? include "team/item.php" ?>
		<? } ?>
	</div>
	
</div>
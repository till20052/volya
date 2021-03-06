<div>
	<h1 class="fwbold">Партія &laquo;ВОЛЯ&raquo;</h1>
</div>

<? $GW = [300, 330] ?>

<div class="mt5">
	<h3>ВОЛЯ — нова партія, яка утворилася після Майдану. В ній — ті, хто зупиняв незаконні забудови, виступав проти сутенерів у суддівських мантіях, ламав «схеми» і «тєми» і боровся за свободу слова та вільний доступ до інформації. Це люди, які творили Євромайдани від Львова до Луганська, які доєдналися до ідеї очищення влади, і так захотіли змін, що самі стали зміною.</h3>
	<h3 class="mt5">Але шлях до змін не буває короткий. Ми зрозуміли, що жоден принцип Майдану не здійсниться без взяття людьми Майдану політичної влади. І тоді домовились: йдемо в політику, але маємо і в політиці поводитись так, як ми хотіли, щоб поводились політики, поки ми були виборцями. </h3>
</div>

<div class="mt30 p15" style="background-color: white; box-sizing: border-box">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" style="width: <?=$GW[0]?>px">
					<div>
						<a href="/party/team" class="fs20">Команда &laquo;ВОЛІ&raquo;</a>
					</div>
					<h3 class="mt5">Ще декілька років тому жоден з нас не міг уявити себе в партії, оскільки більшість із нас — люди, відомі та успішні в інших сферах діяльності. Ми пробували творити зміни в журналістиці, бізнесі, громадській діяльності, але зрозуміли: шлях до змін — це політична діяльність. Саме тому ми об’єдналися, щоби заснувати партію «ВОЛЯ».</h3>
				</td>
				
				<td valign="top" class="pl30">
					<div data-uiGrid="images" onclick="window.location.href = '/party/team'">
						<? foreach($team as $__member){ ?>
							<div>
								<div>
									<div class="avatar" style="background-image: url('/s/img/thumb/ae/<?=$__member["photo"]?>')"></div>
								</div>
								<div class="mt15 tacenter">
									<span><?=$__member["name"][Router::getLang()]?></span>
								</div>
							</div>
						<? } ?>
						<div></div>
					</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<div class="mt30">
	<table cellspacing="0" cellpadding="0" class="fixed_table">
		<tbody>
			<tr>
				
				<td>
					<div>
						<a href="/party/finances" class="fs20"><?=t("Фінанси")?></a>
					</div>
					<h3 class="mt5">Діяльність політичної партії &laquo;ВОЛЯ&raquo; фінансується у відкритий спосіб її прихильниками та членами. Разом сформуємо чесну владу! Будемо вдячні за вашу допомогу.</h3>
				</td>
				
				<td></td>
				
				<td>
					<div>
						<a href="/party/documents" class="fs20"><?=t("Документи")?></a>
					</div>
					<h3 class="mt5">Статут та свідоцтво про реєстрацію партії, документи та інструкції для набуття членства в партії, створення та реєстрація первинних осередків, проведення установчих зборів ППО.</h3>
				</td>
				
				<td></td>
				
				<td>
					<div>
						<a href="/party/agitation" class="fs20"><?=t("Агітація")?></a>
					</div>
					<h3 class="mt5">Завантажте та використовуйте ці матеріали для самостійної агітації за партію &laquo;ВОЛЯ&raquo; та її кандидатів на парламенських виборах.</h3>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>
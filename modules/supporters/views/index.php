<? include "common/header.php"; ?>

<div>

	<div class="msg_ok">
		<?=t("Дякуємо за Вашу підтримку ! Ваші данні успішно збережені")?>
	</div>

	<div class="form">

		<h3>Прохання заповнити у випадку, якщо ви підтримаєте на виборах до районних рад м.Києва, що відбудуться 27 березня 2015 року політичну партію ВОЛЯ. Дякую</h3>

		<form action="/supporters/add" method="post">

			<div data-block="personal">
				<div class="block-title">
					<?=t("Персональна інформація")?>
				</div>

				<div>
					<div class="title">
						<?=t("Прізвище")?> <span style="color:red">*</span>
					</div>
					<div class="input">
						<input name="lname" type="text" class="textbox">
					</div>
				</div>
				<div class="cboth"></div>

				<div>
					<div class="title">
						<?=t("Ім'я")?> <span style="color:red">*</span>
					</div>
					<div class="input">
						<input name="fname" type="text" class="textbox">
					</div>
				</div>
				<div class="cboth"></div>

				<div>
					<div class="title">
						<?=t("По батькові")?> <span style="color:red">*</span>
					</div>
					<div class="input">
						<input name="mname" type="text" class="textbox">
					</div>
				</div>
				<div class="cboth"></div>

				<div>
					<div class="title">
						<?=t("Дата народження")?> <span style="color:red">*</span>
					</div>
					<div class="input">
						<select id="bday" class="mr15" style="width:100px"></select><!--
						--><select id="bmonth" class="mr15" style="width:150px"></select><!--
						--><select id="byear" style="width:125px"></select>
					</div>
				</div>
				<div class="cboth"></div>
			</div>

			<div data-block="contacts">
				<div class="block-title">
					<?=t("Контактна інформація")?>
				</div>

				<div>
					<div class="title">
						<?=t("Телефон")?> <span style="color:red">*</span>
					</div>
					<div class="input">
						<input ui="phone" type="text" class="textbox">
					</div>
				</div>
				<div class="cboth"></div>

				<div>
					<div class="title">
						Email <span style="color:red">*</span>
					</div>
					<div class="input">
						<input name="email" type="text" class="textbox">
					</div>
				</div>
				<div class="cboth"></div>

				<div>
					<div class="title">
						<?=t("Адреса")?> <span style="color:red">*</span>
					</div>
					<div class="input">
						<table width="100%" cellspacing="0" cellpadding="0">
							<td>
								<input type="text" id="street" placeholder="<?=t("вулиця")?>" class="textbox" style="width:100%" />
							</td>
							<td width="20%" class="pl15">
								<input type="text" id="house_number" placeholder="<?=t("буд")?>" class="textbox" style="width:100%" />
							</td>
							<td width="20%" class="pl15">
								<input type="text" id="apartment_number" placeholder="<?=t("кв")?>" class="textbox" style="width:100%" />
							</td>
						</table>
					</div>
				</div>
				<div class="cboth"></div>
			</div>

			<div data-block="election">
				<div class="block-title">
					<?=t("Додаткова інформація")?>
				</div>

				<div>
					<div class="title">
						<?=t("Місцеві вибори 2015")?> <span style="color:red">*</span>
					</div>
					<div class="input">
						<input name="area" type="text" class="textbox">
						<span>Вкажіть у якому районі (дільниці) міста Києва ви голосували на місцевих виборах у 2015 році</span>
					</div>
				</div>
				<div class="cboth"></div>

				<div>
					<div class="title">
						<?=t("Код ДРФО")?>
					</div>
					<div class="input">
						<input name="ic" type="text" class="textbox">
					</div>
				</div>
				<div class="cboth"></div>
			</div>

			<div class="msg_err">
				<?=t("Перевірте правильність заповнення полів")?>
			</div>

			<a data-action="send" class="k-button button-yellow fright mb10"><?=t("Відправити")?></a>
			<div class="cboth"></div>

		</form>

	</div>

</div>
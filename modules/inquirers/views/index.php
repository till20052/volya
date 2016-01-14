<? include "common/header.php"; ?>

<div>

	<div>

		<a href="/inquirers/admin">
			<div class="menu-box">
				<div class="menu-box-icon pt5">
					<i class="icon icon-details"></i>
				</div>
				<div class="menu-box-title pt10">
					<?=t("Анкета")?>
				</div>
			</div>
		</a>

		<a href="/inquirers/answers">
			<div class="menu-box ml30">
				<div class="menu-box-icon pt5">
					<i class="icon icon-check"></i>
				</div>
				<div class="menu-box-title pt10">
					<?=t("Відповіді")?>
				</div>
			</div>
		</a>

		<a href="/register/analytics">
			<div class="menu-box ml30">
				<div class="menu-box-icon pt5">
					<i class="icon icon-barchartasc"></i>
				</div>
				<div class="menu-box-title pt10">
					<?=t("Аналітика")?>
				</div>
			</div>
		</a>

		<?// if($cred->showSettings){ ?>
			<a href="/register/admin">
				<div class="menu-box ml30">
					<div class="menu-box-icon pt5">
						<i class="icon icon-collabtive"></i>
					</div>
					<div class="menu-box-title pt10">
						<?=t("Налаштування")?>
					</div>
				</div>
			</a>
		<?// } ?>

		<div class="cboth"></div>

	</div>

</div>
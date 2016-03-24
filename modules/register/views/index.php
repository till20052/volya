<? include "common/header.php"; ?>

<div>

	<div>

		<a href="/register/members">
			<div class="menu-box">
				<div class="menu-box-icon pt5">
					<i class="icon icon-visitor"></i>
				</div>
				<div class="menu-box-title pt10">
					<?=t("Члени")?>
				</div>
			</div>
		</a>

		<a href="/register/structures">
			<div class="menu-box ml30">
				<div class="menu-box-icon pt5">
					<i class="icon icon-branch"></i>
				</div>
				<div class="menu-box-title pt10">
					<?=t("Осередки")?>
				</div>
			</div>
		</a>

		<a href="/register/documents">
			<div class="menu-box ml30">
				<div class="menu-box-icon pt5">
					<i class="icon icon-document"></i>
				</div>
				<div class="menu-box-title pt10">
					<?=t("Документи")?>
				</div>
			</div>
		</a>

		<? if($cred->showSettings){ ?>
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
		<? } ?>

		<div class="cboth"></div>

	</div>

</div>
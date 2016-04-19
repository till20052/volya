<? include "common/header.php"; ?>

<div data-box="structure" class="section" layout="column">

	<? if($structure["status"] == 0){ ?>
		<div data-role="notices">
			<div data-notice-type="error" style="display: block; opacity: 1;">
				<i class="fa fa-times-circle"></i>
				<p>Помилка : <span>Нажаль дана партійна організація ще не зареєстрована</span></p>
				<div class="cboth"></div>
			</div>
		</div>
	<? } else{ ?>

		<div ng-init="sid = <?=$structure["id"]?>">

			<div data-id="content">
				<? include "item/content.php"; ?>
			</div>

			<div data-id="sidebar">
				<? include "item/sidebar.php"; ?>
			</div>
			<div class="cboth"></div>

		</div>

	<? } ?>

</div>
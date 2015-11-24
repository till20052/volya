<div data-id="tabstrip">
	<ul>
		<li class="k-state-active">
			<?=t("Документи")?>
		</li>
<!--		<li>-->
<!--			--><?//=t("Новини")?>
<!--		</li>-->
		<li>
			<?=t("Члени")?>
		</li>
<!--		<li>-->
<!--			--><?//=t("Заявки на членство")?>
<!--		</li>-->
	</ul>
	<div>
		<? include "tabs/documents.php"; ?>
	</div>
<!--	<div>-->
<!--		--><?// include "tabs/news.php"; ?>
<!--	</div>-->
	<div>
		<? include "tabs/members.php"; ?>
	</div>
<!--	<div>-->
<!--		-->
<!--	</div>-->
</div>

<? //Console::log( $structure ); ?>
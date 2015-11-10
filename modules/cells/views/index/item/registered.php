<div data-uiTabbar="main">
	<ul>
		<li>
			<a href="javascript:void(0);" data-boxId="documents"><?=t("Документи")?></a>
		</li>
		<li>
			<a href="javascript:void(0);" data-boxId="news"><?=t("Новини")?></a>
		</li>
		<li>
			<a href="javascript:void(0);" data-boxId="users"><?=t("Члени осередку")?></a>
		</li>
<!--	<li>
			<a href="javascript:void(0);" data-boxId="photo"><?=t("Фото")?></a>
		</li>-->
	</ul>

	<? include "documents.php" ?>
	<? include "news.php" ?>
	<? include "users.php" ?>
	<? //include "item/photo.php" ?>

</div>
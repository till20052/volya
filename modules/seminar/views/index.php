<div class="header">
	<div>
		<h1><?=t("Партійні матеріали. Семінар")?></h1>
	</div>
</div>

<div class="section mt30">

	<div data-ui="materials">

		<div>
			<h1><?=t("Для депутатів")?></h1>
			<section>
				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>
					<tr>

						<td>
							<? include "common/tabs.php" ?>
						</td>

					</tr>
					<tr>
						<td>
							<? if( ! isset($tab)) $tab = "legislation"; ?>
							<? include "common/".$tab.".php" ?>
						</td>
					</tr>
					</tbody>
				</table>
			</section>
		</div>

		<div>
			<h1><?=t("Інші матеріали")?></h1>
		</div>

		<? if(count($files) > 0){ ?>
			<? foreach($files as $__groupId => $__files){ ?>

				<? if( ! ($__group = PMGroupsModel::i()->getItem($__groupId))){ continue; } ?>
				<? if($__groupId == 11){ continue; } ?>

				<div>
					<header>
						<h3><?=$__group["name"]?></h3>
					</header>
					<section>
						<ul>
							<? foreach($__files as $__file){ ?>
								<li>
									<div class="pic">
										<div class="icon">
											<i class="icon-file"></i>
										</div>
									</div>
									<div class="name">
										<a href="/s/storage/<?=$__file["hash"]?>" target="_blank"><?=$__file["name"]?></a>
									</div>
								</li>
							<? } ?>
							<li></li>
						</ul>
					</section>
				</div>

			<? } ?>
		<? } else { ?>
			<div class="empty"><?=t("Ще намає матеріалів")?></div>
		<? } ?>

	</div>

</div>
<div data-id="tabstrip" data-style="structure">

	<ul>
		<li class="k-state-active">
			<?=t("РЕЄСТР РІШЕНЬ")?>
		</li>
		<li>
			<?=t("ЧЛЕНИ ПАРТІЇ")?>
		</li>
	</ul>
	<div>
		<? include "tabs/documents.php"; ?>
	</div>
	<div>
		<? include "tabs/members.php"; ?>
	</div>

</div>

<? if(isset($structure["structures"])){ ?>
	<div data-block="substructures">
		<div data-block="blockTitle"><?=t("Підлеглі партійні організації")?></div>
		<div class="cboth"></div>

		<div data-block="blockContent">
			<? $__delimiter = false; ?>
			<? foreach ($structure["structures"] as $substructure) { ?>
				<div <?= ! $__delimiter ? "class='dotted'" : ""?> data-block="info">
					<a href="/structures/<?=$substructure["id"]?>"><b><?=$substructure["title"]?></b></a>
					<hr />

					<div class="mt10 mb10">
						<div class="title">
							<?=t("Статус")?> :
						</div>
						<div class="value">
							<?=$substructure["verification"] ? "<b class='registered'>" . t("Зареєстровано") . "</b>" : "<b class='notregistered'>" . t("Не зареєстровано") . "</b>"?>
						</div>
					</div>
					<div class="cboth"></div>

					<div class="mt10 mb10">
						<div class="title">
							<?=t("Локація")?> :
						</div>
						<div class="value">
							<?=$substructure["locality"]?>
						</div>
					</div>
					<div class="cboth"></div>

					<div class="mt10 mb10">
						<div class="title">
							<?=t("Адреса")?> :
						</div>
						<div class="value">
							<?=$substructure["address"]?>
						</div>
					</div>
					<div class="cboth"></div>

					<div class="mt10 mb10">
						<div class="title">
							<?=t("Рівень")?> :
						</div>
						<div class="value">
							<?=$substructure["level"]?>
						</div>
					</div>
					<div class="cboth"></div>

					<? if($substructure["verification"]){ ?>
						<div class="mt10 mb10">
							<div class="title">
								<?=t("Перевірено")?> :
							</div>
							<div class="value">
								<div>

									<? $user_verifier = $substructure["verification"]["user_verifier"]; ?>

									<div class="avatar fleft" <? if($user_verifier["avatar"]){?>style="background-image: url('http://volya.ua/s/img/thumb/ac/<?=$user_verifier["avatar"]?>');"<?}?>>
										<? if( ! $user_verifier["avatar"]){ ?>
											<i class="icon icon-user"></i>
										<? } ?>
									</div>
									<div class="fleft ml5 fs13">
										<?=$user_verifier["name"]?>
									</div>
									<div class="fleft ml5 cgray">
										<?=$substructure["verification"]["created_at"] ?>
									</div>
									<div class="cboth"></div>
								</div>
							</div>
						</div>
						<div class="cboth"></div>
					<? } ?>
				</div>

				<? if($__delimiter && count($structure["structures"]) > 2){ $__delimiter = false; ?>
					<hr class="delimiter" />
				<? } else $__delimiter = true; ?>
			<? } ?>
			<div class="cboth"></div>

		</div>
	</div>
<? } ?>
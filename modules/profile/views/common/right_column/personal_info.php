<div data-uibox="personalInfo">
		
	<header>
		<? if($profile["id"] == UserClass::i()->getId()){ ?>
			<span><?=t("Моя персональна інформація")?></span>
		<? } else { ?>
			<span><?=t("Персональна інформація")?></span>
		<? } ?>
	</header>

	<section>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr style="<?=$profile["education"] == "" ? "display:none;" : ""?>">
					<td>
						<span class="fwbold fs13"><?=t("Освіта")?>:</span>
						<p><?=$profile["education"]?></p>
					</td>
				</tr>
				<tr style="<?=$profile["jobs"] == "" ? "display:none;" : ""?>">
					<td>
						<span class="fwbold fs13"><?=t("Професійна діяльність")?>:</span>
						<p><?=$profile["jobs"]?></p>
					</td>
				</tr>
				<tr style="<?=$profile["social_activity"] == "" ? "display:none;" : ""?>">
					<td>
						<span class="fwbold fs13"><?=t("Громадська діяльність")?>:</span>
						<p><?=$profile["social_activity"]?></p>
					</td>
				</tr>
				<tr style="<?=$profile["political_activity"] == "" ? "display:none;" : ""?>">
					<td>
						<span class="fwbold fs13"><?=t("Політична діяльність")?>:</span>
						<p><?=$profile["political_activity"]?></p>
					</td>
				</tr>
			</tbody>
		</table>
	</section>

</div>
<? foreach($list as $__item){ ?>
	<tr>

		<td>
			<!-- START AVATAR -->
			<div class="avatar avatar-2x"<? if($__item["avatar"] != ""){ ?> style="background-image:url('/s/img/thumb/ai/<?=$__item["avatar"]?>')"<? } ?>>
				<? if($__item["avatar"] == ""){ ?>
					<i class="icon-user"></i>
				<? } ?>
			</div>
			<!-- END AVATAR -->
		</td>

		<td>
			<div>
				<a href="/profile/<?=$__item["id"]?>" class="fwbold"><?=$__item["name"]?></a>
			</div>
			<? if($__item["city_id"] > 0){ ?>
				<div><?=$__item["city_name"]?></div>
			<? } ?>
		</td>

		<? if(UserClass::i()->isAuthorized()){ ?>
			<td ui="subscribe" class="taright">
				<? if( ! UsersFriendsModel::i()->areFriends(UserClass::i()->getId(), $__item["id"])) { ?>
					<a href="javascript:void(0);" id="send" data-id="<?=$__item["id"]?>" class="v-button"><?=t("Підписатися")?></a>
					<div id="loading" class="dnone"><img src="/kendo/styles/Volya/loading_2x.gif" /></div>
					<div id="done" class="dnone"><i class="icon-ok"></i> <span><?=t("Підписка оформлена")?></span></div>
				<? } else { ?>
					<div id="done" class="icon">
						<i class="icon-ok"></i>
						<span><?=t("Підписка оформлена")?></span>
					</div>
				<? } ?>
			</td>
		<? } ?>

	</tr>
<? } ?>
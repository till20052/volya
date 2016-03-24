<? foreach($list as $__item){ ?>
	<tr>
		
		<td>
			<input type="checkbox" />
		</td>
		
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

		<td valign="middle" style="width:180px">
			<div>
				<a href="javascript:void(0);" ui="send_message" data-id="<?=$__item["id"]?>" data-name="<?=$__item["name"]?>" class="icon">
					<i class="icon-emailalt"></i>
					<span><?=t("Написати повідомлення")?></span>
				</a>
			</div>
			<div>
				<a href="javascript:void(0);" ui="remove" data-id="<?=$__item["id"]?>" class="icon">
					<i class="icon-remove"></i>
					<span><?=t("Видалити з кола")?></span>
				</a>
			</div>
		</td>

	</tr>
<? } ?>
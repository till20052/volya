<? foreach($conversations as $item){ ?>
	
	<? $uid = array() ?>
	<? $name = array() ?>
	<? foreach($item["users"] as $user){
		$uid[] = $user["id"];
		$name[] = "<a href=\"/profile/".$user["id"]."\">".$user["name"]."</a>";
	} ?>

	<tr data-id="<?=$item["id"]?>" data-uid="<?=implode(",", $uid)?>" data-subject="<?=$item["subject"]?>">

<!--		<td>
			<input type="checkbox" />
		</td>-->

		<td>
			<? if(count($item["users"]) == 1){ ?>
				<!-- START AVATAR -->
				<div class="avatar avatar-2x"<? if($item["users"][0]["avatar"] != ""){ ?> style="background-image:url('/s/img/thumb/ai/<?=$item["users"][0]["avatar"]?>')"<? } ?>>
					<? if($item["users"][0]["avatar"] == ""){ ?>
						<i class="icon-user"></i>
					<? } ?>
				</div>
				<!-- END AVATAR -->
			<? } else { ?>
				<div class="avatar avatar-2x">
					<i class="icon-groups-friends"></i>
				</div>
			<? } ?>
		</td>
		
		<td>
			<div class="fs12 tacenter">
				<div><?=date("d.m.Y", strtotime($item["messages"][0]["created_at"]))?></div>
				<div><?=date("H:i:s", strtotime($item["messages"][0]["created_at"]))?></div>
			</div>
			<div class="mt5"><?=implode(", ", $name)?></div>
		</td>
		
		<td>
			<? if($item["subject"] != ""){ ?>
				<div class="fwbold">
					<a href="javascript:void(0);"><?=$item["subject"]?></a>
				</div>
			<? } ?>
			<div<? if($item["subject"] != ""){ ?> class="mt15"<? } ?> style="color:#666"><?=$item["messages"][0]["message"]?></div>
		</td>

	</tr>

<? } ?>

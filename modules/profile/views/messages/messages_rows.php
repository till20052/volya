<? foreach($messages as $item){ ?>
	
	<tr>

		<td>
			<!-- START AVATAR -->
			<div class="avatar avatar-2x"<? if($item["user"]["avatar"] != ""){ ?> style="background-image:url('/s/img/thumb/ai/<?=$item["user"]["avatar"]?>')"<? } ?>>
				<? if($item["user"]["avatar"] == ""){ ?>
					<i class="icon-user"></i>
				<? } ?>
			</div>
			<!-- END AVATAR -->
		</td>
		
		<td>
			<div>
				<a href="/profile/<?=$item["user"]["id"]?>"><?=$item["user"]["name"]?></a>
			</div>
			<div class="mt5" style="color:#666"><?=$item["message"]?></div>
		</td>
		
		<td>
			<div class="fs12 tacenter" style="color:#999">
				<div><?=date("d.m.Y", strtotime($item["created_at"]))?></div>
				<div><?=date("H:i:s", strtotime($item["created_at"]))?></div>
			</div>
		</td>

	</tr>

<? } ?>

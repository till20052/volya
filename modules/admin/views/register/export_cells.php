<div>
	
	<div>
		<div class="tacenter fs16 fwbold"><?=t("Витяг з Єдиного реєстру членів партії та партійних організацій")?></div>
	</div>
	
	<div class="mt30">
		
		<table width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Інформація</th>
					<th>Учасники</th>
					<th>Дільниця</th>
					<th>Дата уст. зборів</th>
				</tr>
			</thead>
			<tbody>
				<? $interationIndex = 0 ?>
				<? foreach($list as $item){ ?>
					<tr>
						<td align="center" width="5%"><?=($interationIndex + 1)?></td>
						<td>
							<div class="fwbold"><?=t("Первиний осередок партії ВОЛЯ №")?><?=$item["number"]?></div>
							<div><?=$item["locality"]?></div>
							<div><?=$item["address"]?></div>
						</td>
						<td align="center">
							<? foreach($item["members"] as $__member){ ?>
								<div>
									<a href="/profile/<?=$__member["id"]?>"><?=$__member["name"]?></a>
								</div>
							<? } ?>
						</td>
						<td width="15%" align="center">
							<?=$item["polling_places"][0]["number"]?>
						</td>
						<td width="10%" align="center"><?=$intlDateFormatter->format(strtotime($item["started_at"]))?></td>
					</tr>
					<? $interationIndex++ ?>
				<? } ?>
			</tbody>
		</table>
		
	</div>
	
	<div class="mt30">
		<div><?=t("Всього")?>: <?=$interationIndex?></div>
	</div>
	
</div>
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
					<th>Статус</th>
					<th>Контакти</th>
				</tr>
			</thead>
			<tbody>
				<? $interationIndex = 0 ?>
				<? foreach($list as $item){ ?>
					<tr>
						<td align="center" width="5%"><?=($interationIndex + 1)?></td>
						<td>
							<div class="fwbold"><?=UserClass::i($item["id"])->getName("&ln &fn &mn")?></div>
							<? if( ! is_null($item["geo_koatuu_code"]) || $item["geo_koatuu_code"] != ""){ ?>
								<div style="color: #333"><?=UserClass::i($item["id"])->getLocality()?></div>
							<? } ?>
						</td>
						<td width="25%" align="center"><?=UserClass::getType($item["type"])["text"]?></td>
						<td align="center">
							<? if( ! empty($item["contacts"]["email"])){ ?>
								<? foreach($item["contacts"]["email"] as $email){ ?>
									<div><?=$email?></div>
								<? } ?>
							<? } ?>
							<? if( ! empty($item["contacts"]["phone"])){ ?>
								<? foreach($item["contacts"]["phone"] as $phone){ ?>
									<div><?=$phone?></div>
								<? } ?>
							<? } ?>
						</td>
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
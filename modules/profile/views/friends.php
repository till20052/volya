<div class="header">
	<div>
		<table width="100%" cellpadding="0" cellspacing="0">
			<td>
				<h1 class="ttuppercase"><?=t("Коло")?></h1>
			</td>
		</table>
	</div>
</div>

<div>
	<div>
		
		<div class="tabbar">
			<ul>
				<li>
					<a href="/people"><?=t("Всі")?></a>
				</li>
				<li class="selected">
					<a href="/profile/friends"><?=t("Моє коло")?></a>
				</li>
			</ul>
		</div>
		
	</div>
</div>

<div class="mt30">
	<div>
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					
					<td valign="top">
						<div>
							<table class="list" width="100%" cellspacing="0" cellpadding="0" data-count="<?=$count?>">

								<tbody>

									<? include "friends/table_rows.php"; ?>

								</tbody>

							</table>
						</div>
						
						<? if($count > count($list)) { ?>
							<div class="mt30 tacenter">
								<a href="javascript:void(0);" id="show_more" class="v-button v-button-yellow"><?=t("Показати ще")?></a>
							</div>
						<? } ?>
					</td>
					
					<td width="300px" valign="top" class="pl30">
						
						<? include "common/right_column.php" ?>
						
					</td>
				
				</tr>
				
			</tbody>
			
		</table>
		
	</div>
</div>
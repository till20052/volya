<div class="header">
	
	<div>
		
		<div>
		
			<table width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td>
							<h1><?=t("Адмін панель")?></h1>
						</td>
					</tr>
				</tbody>
			</table>
			
		</div>
		
	</div>

</div>

<div class="section mt30">
	
	<div>
		
		<table style="width: 100%; table-layout: fixed">
			<tbody>
				<? $__counter = 0; ?>
				<? $__rowsCounter = 0; ?>
				<? $__columnsCount = 8; ?>
				<? foreach($modules as $__item){ ?>
					<? if($__counter == 0){ ?>
						<tr>
					<? } ?>

					<td valign="top" class="tacenter"<? if($__rowsCounter > 0){ ?> style="padding-top: 20px"<? } ?>>
						<div>
							<a href="<?=$__item["a.href"]?>"><img src="<?=$__item["img.src"]?>" /></a>
						</div>
						<div>
							<a href="<?=$__item["a.href"]?>"><?=str_replace(" ", "<br />", t($__item["a.text"]))?></a>
						</div>
					</td>

					<? if($__counter == $__columnsCount - 1){ ?>
						</tr>
						<? $__rowsCounter++ ?>
						<? $__counter = 0; ?>
					<? } else { ?>
						<? $__counter++ ?>
					<? } ?>
				<? } ?>

				<? if($__counter != 0 && $__counter != $__columnsCount){ ?>
						<td colspan="<?=( $__columnsCount - $__counter )?>"></td>
					</tr>
				<? } ?>
			</tbody>
		</table>
		
	</div>
	
</div>
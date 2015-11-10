<script id="data">(<?=json_encode(array(
	"regions" => $geo["regions"],
	"roep" => array(
		"regions" => $roep["regions"]
	)
))?>);</script>

<div class="header">
	<div>
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<td>
				<h1 class="ttuppercase"><?=t("Єдиний реєстр осередків та організацій")?></h1>
			</td>
			<? if(
					! CellsModel::i()->isCreator(UserClass::i()->getId())
//					&& ! CellsModel::i()->isMember(UserClass::i()->getId())
			){ ?>
			<td class="taright">
				<a href="javascript:void(0);" id="create_cell" class="icon v-button v-button-blue">
					<i class="icon-plus-sign"></i>
					<span><?=t("Створити")?></span>
				</a>
			</td>
			<? } ?>
		</table>
		
	</div>
</div>

<div>
	<div>
		
		<table width="100%" cellspacing="0" cellpadding="0">
			
			<td valign="top">
				
				<div>
					<table class="list" width="100%" cellspacing="0" cellpadding="0" data-count="<?=$count?>">
						<tbody>

							<? include "list/table_rows.php"; ?>

						</tbody>
					</table>
				</div>
				
			</td>
			
			<td width="300px" valign="top" class="pl30">
				&nbsp;
			</td>
			
		</table>
		
	</div>
</div>
<?php

function menu($tree, $attr = "", $menuClickable)
{
	if( ! (count($tree) > 0))
	{
		return;
	}
	
	?><ul<? if($attr != ""){ ?> <?=$attr?><? } ?>><?
	
	foreach($tree as $__item)
	{
		$__isSelected = (strpos(Uri::getUrn(), $__item["href"]) === 0) ? true : false;
		$__isClickable = ! $__isSelected ? true : false;
		if($__isSelected && isset($menuClickable) && $menuClickable)
			$__isClickable = true;
		?><li<? if($__isSelected){ ?> class="selected"<? } ?>>
			<? if($__isClickable){ ?>
				<a href="http://volya.ua<?=$__item["href"]?>">
			<? } else { ?>
				<div>
			<? } ?>
			
			<?=$__item["name"][Router::getLang()]?>
			
			<? if($__isClickable){ ?>
				</a>
			<? } else { ?>
				</div>
			<? } ?>
		</li><?
	}

	if(UserClass::i()->isAuthorized())
	{
		?><li><a href="http://volya.ua/seminar"><?= t("Семінар") ?></a></li><?
	}

	?><li><a href="http://volya.ua/subsydia"><?= t("Субсидія") ?></a></li><?
	?><li><a href="http://volya.ua/hromada"><?= t("Об'єднання громад") ?></a></li><?

	?></ul><?
}

?>

<?=menu($mainMenu, 'data-ui-menu="main"', isset($menuClickable) ? $menuClickable : false)?>
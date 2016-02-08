<div>
	<header><?=t("Питання")?></header>
	<div ui-box="blocks" style="height: 250px; padding-top: 3px">
		<select data-ui-ddl="blocks">
			<option value="0"><?=t("Оберіть блок питань")?></option>
			<? foreach($forms as $__blocks){ ?>
				<? foreach($__blocks as $__block){ ?>
					<option value="<?=$__block['id']?>"><?=$__block['title']?></option>
				<? } ?>
			<? } ?>
		</select>

		<select data-ui-ddl="blocks" class="mt10" disabled>
			<option value="0"><?=t("Оберіть питання")?></option>
		</select>

		<input data-ui-ddl="answers" style="margin: 10px 3px 0 3px" disabled placeholder="<?=t("Оберіть відповідь")?>">
		<div class="fsitalic tacenter cgray p5"><?=t("Ви можете обрати декілька відповідей, якщо питання це передбачає")?></div>
	</div>
</div>
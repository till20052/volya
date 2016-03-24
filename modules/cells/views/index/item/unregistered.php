<div class="fs17 <?=count($cell["members"]) >= 3 ? "dnone" : ""?>">
	<?=t("Зараз іде процес утворення мережі первинних осередків партії. Ви можете долучитися до цього процесу створивши осередок у своєму населеному пункті. Коли кількість учасників досягне 3 людей, ви зможете офіційно зареєструвати осередок.")?>
</div>
<div class="fs17 <?=count($cell["members"]) < 3 ? "dnone" : ""?>">
	<p><?=t("Кількість учасників вашого осередку досягла 3 людей, тепер ви можете офіційно зареєструвати осередок. На скриньку ел.  пошти усім учасникам осередку відправлено листа з інформацією про подальші дії.")?></p>
	<p><?=t("Домовляйтеся про зустріч для проведення установчих зборів та дотримуйтеся")?> <a><?=t("інструкції по створенню осередку")?></a>.</p>
</div>

<div class="<?=$is_member ? "dnone" : ""?>">
	<? if( ! $is_already_in_cell){ ?>
		<a href="/cells/connect_to_cell?cell_id=<?=$cell["id"]?>" id="find" class="v-button v-button-blue" style="padding: 10px 40px">
			<?=t("Вступити до осередку")?>
		</a>
	<? } ?>
</div>

<div class="pt15 mt15 <?=! $is_member ? "dnone" : ""?> protocols" style="border-top: 1px solid #F0EFEB">
	<table>
		<tr>
			<td><?=t("Якщо установчі збори ще не проводилися")?>:</td>
			<td class="pl15"><?=t("Якщо установчі збори вже проведені")?>:</td>
		</tr>
		<tr>
			<td>
				<div class="doc">
					<div class="icon">
						<i class="icon-download-alt"></i>
					</div>
					<a href="/upload/how_to_register_a_primary_cell.Pdf">
						<?=t("Завантажити шаблон")?>
					</a>
					<span><?=t("протоколу установчих зборів")?></span>
				</div>
			</td>
			<td>
				<div class="doc uploadProtocol fright <?=count($cell["documents"]) > 0 ? "dnone" : ""?>">
					<div class="icon">
						<i class="icon-uploadalt pl10"></i>
					</div>
					<input type="file" id="send_protocol" data-cell-id="<?=$cell["id"]?>" name="document" />
					<a href="javascript::void(0)">
						<?=t("Відправити протокол")?>
					</a>
					<span><?=t("установчих зборів на перевірку")?></span>
				</div>
				<div class="uploaded doc fright <?=count($cell["documents"]) > 0 ? "" : "dnone"?>">
					<div class="icon">
						<i class="icon-ok"></i>
					</div>
					<a><?=t("Протокол завантажено")?></a>
					<span><?=t("")?></span>
				</div>
			</td>
		</tr>
	</table>
</div>

<div class="pt15 mt15" style="border-top: 1px solid #F0EFEB" class="pb10">
	<span class="fs20"><?=t("До осередку вже долучилися")?></span>
</div>

<table class="members">

	<? $__counter = 0; ?>
	<? $__columnsCount = 2; ?>

	<? foreach ($cell["members"] as $member) {
	?>
		<? if($__counter == 0){ ?>
			<tr>
		<? } ?>

		<td>
			<div class="avatar avatar-2x fleft" style="background-image:url('/s/img/thumb/aa/<?=$member["avatar"]?>');"></div>
			<div class="pt10 name">
				<a href="/profile/<?=$member["id"]?>"><?=$member["last_name"]." ".$member["first_name"]?></a>
			</div>
		</td>

		<? if($__counter == $__columnsCount - 1){ ?>
			</tr>
			<? $__counter = 0; ?>
		<? } else { ?>
			<? $__counter++ ?>
		<? } ?>

	<? } ?>
</table>
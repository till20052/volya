<table width="100%" cellspacing="0" cellpadding="0">
	<tbody>
		
		<? $__tdIndentAttr = " colspan=\"3\" style=\"height: 15px\"" ?>
		
		<tr>
			<td width="25%">&nbsp;</td>
			<td width="50%">
				<label>
					<input type="checkbox" data-ui="in_election" />
					<span><?=t("Включити до розділу Вибори 2014")?></span>
				</label>
			</td>
			<td width="25%">&nbsp;</td>
		</tr>
		
		<tr>
			<td<?=$__tdIndentAttr?>>&nbsp;</td>
		</tr>
		
		<tr>
			<td class="taright pr15"><?=t("Кандидат")?></td>
			<td>
				<select data-ui="election_candidates" style="width: 100%">
					<script>(<?=json_encode($electionCandidates)?>);</script>
				</select>
			</td>
			<td>&nbsp;</td>
		</tr>
		
	</tbody>
</table>
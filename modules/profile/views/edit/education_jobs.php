<div data-uiBox="education_jobs" class="dnone">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			
<!--			<tr>
				<td width="<?//=$leftColumnWidth?>"><?=t("Освіта")?></td>
				<td>
					<textarea id="education" class="k-textbox" style="width: 100%"><?=$profile["education"]?></textarea>
				</td>
			</tr>-->
			
			<tr>
				<td width="<?=$leftColumnWidth?>"><?=t("Освіта")?></td>
				<td colspan="2">
					<select data-ui="education_level" style="width:100%">
						<option value="0">&mdash;</option>
						<option value="1">Вища</option>
						<option value="2">Середня / Спеціальна</option>
						<option value="3">Закордонна</option>
						<option value="4">Незакінчена вища</option>
					</select>
				</td>
			</tr>
			
			<tr><td colspan="2" style="height: 15px;"></td></tr>
			
			<tr>
				<td class="pr20"><?=t("Який Ваш професійний статус")?> ?</td>
				<td colspan="2">
					<select data-ui="professional_status" style="width:100%">
						<option value="0">&mdash;</option>
						<option value="1">Власник / Підприємець</option>
						<option value="2">Керівник вищої ланки </option>
						<option value="3">Керівник середньої ланки</option>
						<option value="4">Спеціаліст</option>
						<option value="5">Студент</option>
					</select>
				</td>
			</tr>
			
			<tr><td colspan="2" style="height: 15px;"></td></tr>
			
			<tr>
				<td class="pr20"><?=t("Сфера роботи")?></td>
				<td colspan="2">
					<select data-ui="employment_scope" style="width:100%"></select>
				</td>
			</tr>

			<tr><td colspan="2" style="height: 15px;"></td></tr>
			
			<tr>
				<td>
					<?=t("Професійна діяльність")?></br>
					<span style="color: gray" class="fs11"><?=t("(місця роботи, посади, які Ви займали)")?></span>
				</td>
				<td>
					<textarea id="jobs" class="k-textbox" style="width: 100%"><?=$profile["jobs"]?></textarea>
				</td>
			</tr>
			
			<tr><td colspan="2" style="height: 15px;"></td></tr>
			
			<tr>
				<td>
					<?=t("Громадська діяльність")?></br>
					<span style="color: gray" class="fs11"><?=t("(участь в громадських рухах, проектах, організаціях)")?></span>
				</td>
				<td>
					<textarea id="social_activity" class="k-textbox" style="width: 100%"><?=$profile["social_activity"]?></textarea>
				</td>
			</tr>
			
			<tr><td colspan="2" style="height: 15px;"></td></tr>
			
			<tr>
				<td>
					<?=t("Політична діяльність")?></br>
					<span style="color: gray" class="fs11"><?=t("(участь в політичних партіях, виборні посади, які займали та від якої політичної сили)")?></span>
				</td>
				<td>
					<textarea id="political_activity" class="k-textbox" style="width: 100%"><?=$profile["political_activity"]?></textarea>
				</td>
			</tr>
			
			<tr><td colspan="2" style="height: 15px;"></td></tr>
			
		</tbody>
	</table>
	
</div>
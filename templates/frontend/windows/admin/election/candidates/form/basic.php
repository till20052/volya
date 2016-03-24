<table width="100%" cellspacing="0" cellpadding="0">
	<tbody>
		
		<tr>
			<td colspan="2">
				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td class="taright pr15" style="width: 27%"><?=t("Символьне посилання")?>:</td>
							<td>
								<input type="text" id="symlink" class="textbox" style="width: 100%" />
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="height: 15px"></td>
		</tr>
		
		<tr>
			<td style="width: 40%">
				<div data-ui="avatar" class="avatar avatar-8x">
					<div class="avatar avatar-8x">
						<input type="file" name="file" />
						<i class="icon-uploadalt"><?=t("Завантажити")?><br /><?=t("фото")?></i>
					</div>
					<i class="icon-user"></i>
				</div>
			</td>
			<td>

				<div>
					<div><?=t("Призвище")?></div>
					<div>
						<input type="text" id="last_name" class="textbox" style="width: 100%" />
					</div>
				</div>

				<div class="mt5">
					<div><?=t("Ім'я")?></div>
					<div>
						<input type="text" id="first_name" class="textbox" style="width: 100%" />
					</div>
				</div>

				<div class="mt5">
					<div><?=t("По батькові")?></div>
					<div>
						<input type="text" id="middle_name" class="textbox" style="width: 100%" />
					</div>
				</div>

				<div class="mt5">
					<table width="100%" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td width="50%" class="pr5">
									<div><?=t("Область")?></div>
									<div>
										<select data-ui="geo_koatuu_code" style="width: 182px">
											<option value="0">&mdash;</option>
											<? foreach(OldGeoClass::i()->getRegions() as $__region){ ?>
												<option value="<?=$__region["id"]?>"><?=$__region["title"]?></option>
											<? } ?>
										</select>
									</div>
								</td>
								<td width="50%" class="pl5">
									<div><?=t("Номер округу")?></div>
									<div>
										<select data-ui="county_number" style="width: 182px"></select>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

			</td>
		</tr>

		<tr>
			<td colspan="2" style="height: 15px"></td>
		</tr>

		<tr>
			<td colspan="2">
				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td class="taright pr15" style="width: 25%"><?=t("Адреса штабу")?>:</td>
							<td>
								<input type="text" id="staff_address" class="textbox" style="width: 100%" />
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2" style="height: 15px"></td>
		</tr>
		
		<tr>
			<td colspan="2">
				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td class="taright pr15" style="width: 25%"><?=t("Email")?>:</td>
							<td>
								<input type="text" data-id="email" class="textbox" style="width: 322px" />
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2" style="height: 15px"></td>
		</tr>
		
		<tr>
			<td colspan="2">
				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td class="taright pr15" style="width: 25%; padding-top: 9px; vertical-align: top"><?=t("Телефони")?>:</td>
							<td>
								<div data-ui="phone">
									<div>
										<div>
											<input type="text" class="textbox" style="width: 100%" />
										</div>
										<div>
											<a href="javascript:void(0);" data-action="delete" class="icon">
												<i class="icon-circledelete"></i>
											</a>
										</div>
										<div>
											<a href="javascript:void(0);" data-action="add" class="icon">
												<i class="icon-circleadd"></i>
											</a>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="height: 15px"></td>
		</tr>
		
		<tr>
			<td colspan="2">
				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td class="taright pr15" style="width: 25%">
								<div class="icon"><i class="icon-facebook" style="padding: 0"></i></div>
							</td>
							<td>
								<input type="text" data-id="facebook" class="textbox" style="width: 322px" />
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="height: 15px"></td>
		</tr>
		
		<tr>
			<td colspan="2">
				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td class="taright pr15" style="width: 25%">
								<div class="icon"><i class="icon-twitter" style="padding: 0"></i></div>
							</td>
							<td>
								<input type="text" data-id="twitter" class="textbox" style="width: 322px" />
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="height: 15px"></td>
		</tr>
		
		<tr>
			<td colspan="2">
				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td class="taright pr15" style="width: 25%">
								<div class="icon"><i class="icon-websitealt" style="padding: 0"></i></div>
							</td>
							<td>
								<input type="text" data-id="website" class="textbox" style="width: 322px" />
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

	</tbody>
</table>
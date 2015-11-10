<div>
	<div>

		<header>
			<h1><?=t("Субсидія")?></h1>
		</header>

		<section>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>

					<td class="pr30 vatop">
						<article data-ui="calc">
							<header>
								<h1>Орієнтовний розрахунок розміру субсидії на оплату житлово-комунальних послуг</h1>
							</header>

							<section>
								<table width="100%" cellspacing="0" cellpadding="0">
									<tbody>

									<tr>
										<td class="taright pr15">Чисельність осіб зареєстрованих у квартирі (будинку)</td>
										<td>
											<input id="number" type="text" class="textbox" style="width: 100%" />
										</td>
									</tr>

									<tr><td colspan="2" style="height: 5px"></td></tr>

									<tr>
										<td class="taright pr15">Дохід всіх осіб, які проживають в квартирі (будинку) за місяць (гривень)</td>
										<td>
											<input id="income" type="text" class="textbox" style="width: 100%" />
										</td>
									</tr>

									<tr><td colspan="2" style="height: 5px"></td></tr>

									<tr>
										<td class="taright pr15">Сума нарахувань за житлово-комунальні послуги (гривень)</td>
										<td>
											<input id="payment" type="text" class="textbox" style="width: 100%" />
										</td>
									</tr>

									<tr>
										<td colspan="2">
											<hr />
										</td>
									</tr>

									<tr>
										<td class="taright pr15 fwbold">Орієнтовний розмір субсидії (гривень)</td>
										<td class="fs30 fwbold">
											<span id="result">0.00</span>
										</td>
									</tr>

									</tbody>
								</table>

								<div data-ui="messages">
									<div id="success">Звертайтесь до місцевого органу соціального захисту населення</div>
									<div id="error">Cубсидія не буде призначена (перевірте заповненість всіх полів)</div>
								</div>
							</section>
						</article>

						<article>
							<header>
								<h1>Листівки</h1>
							</header>
							<section class="tacenter">
								<table width="75%" style="display: inline-table; table-layout: fixed">
									<tbody>
									<tr>

										<td class="pr5">
											<img src="/img/frontend/subsydia/letter_1_prev.jpg" width="100%">
											<div class="p5 tacenter" style="background: #eee">
												<a href="/img/frontend/subsydia/letter_1.jpg" target="_blank" class="icon">
													<i class="icon-download"></i>
													<span>Завантажити</span>
												</a>
											</div>
										</td>

										<td class="pl5">
											<img src="/img/frontend/subsydia/letter_2_prev.jpg" width="100%">
											<div class="p5 tacenter" style="background: #eee">
												<a href="/img/frontend/subsydia/letter_2.jpg" target="_blank" class="icon">
													<i class="icon-download"></i>
													<span>Завантажити</span>
												</a>
											</div>
										</td>

									</tr>
									</tbody>
								</table>
							</section>
						</article>
					</td>

					<td width="30%" class="vatop">
						<article>
							<header>
								<h1>Документи</h1>
							</header>
							<section>
								<div>
									<a href="/pdf/subsydia/statement.doc" target="_blank" class="icon">
										<i class="icon-document" style="font-size: 50px"></i>
										<span style="text-align: left">Заява про призначення житлової субсидії</span>
									</a>
								</div>

								<div class="mt15">
									<a href="/pdf/subsydia/instruction.docx" target="_blank" class="icon">
										<i class="icon-document" style="font-size: 50px"></i>
										<span style="text-align: left">Інструкція про порядок заповнення бланків</span>
									</a>
								</div>

								<div class="mt15">
									<a href="/pdf/subsydia/declaration.doc" target="_blank" class="icon">
										<i class="icon-document" style="font-size: 50px"></i>
										<span style="text-align: left">Декларація про доходи і витрати осіб, які звернулися за призначенням житлової субсидії</span>
									</a>
								</div>

								<div class="mt15">
									<a href="/pdf/subsydia/how_to_grant.docx" target="_blank" class="icon">
										<i class="icon-document" style="font-size: 50px"></i>
										<span style="text-align: left">Як оформити житлову субсидію?</span>
									</a>
								</div>

								<div class="mt15">
									<a href="/pdf/subsydia/calculation.docx" target="_blank" class="icon">
										<i class="icon-document" style="font-size: 50px"></i>
										<span style="text-align: left">Розрахунок розміру платежа при наданні субсидії</span>
									</a>
								</div>
							</section>
						</article>
					</td>

				</tr>
				</tbody>
			</table>



		</section>

	</div>
</div>
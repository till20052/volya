<? include "common/header.php"; ?>

<?// switch($inquirer){
//	case
//} ?>

<? if( ! $inquirer["form"]){?>

	<div data-role="notices">
		<div data-notice-type="error" style="opacity: 1; display: block">
			<i class="fa fa-times-circle"></i>
			<p>Помилка : <span>Такої анкети не існує</span></p>
			<div class="cboth"></div>
		</div>
	</div>

<? }else{ ?>

	<div class="section">
		<div class="grid" data-form-id="<?=$inquirer["form"]["id"]?>" data-form-geo="<?=$inquirer["form"]["geo"]?>">

			<? foreach ($inquirer["blocks"] as $block) { ?>

				<div class="grid-item" data-block="block" data-block-id="<?=$block["id"]?>">
					<h1 class="block_title"><?=$block["title"]?></h1>

					<? foreach ($block["questions"] as $question) { ?>

						<div class="m10" data-block="question" data-question-id="<?=$question["id"]?>">
							<div class="mb10 ml15">
								<div class="marker"></div>
								<span class="question"><?=$question["title"]?></span>
							</div>

							<? if( ! $question["is_text"]){ ?>
								<? foreach ($question["answers"] as $answer) { ?>
									<div class="m5"
									     data-block="answer"
									     data-block-id="<?=$block["id"]?>"
									     data-question-id="<?=$question["id"]?>"
									     data-question-type="<?=$question["type"]?>"
									     data-answer-id="<?=$answer["id"]?>"
									     data-answer-num="<?=$question["num"]?>"
									     data-answer-type="<?=$answer["is_text"] ? "text" : "answer" ?>"
									>
										<div class="checkbox">
											<i class="icon icon-ok"></i>
										</div>

										<? if($answer["is_text"]){ ?>
											<span class="answer_title"><?=$answer["title"]?> :</span> <textarea class="textbox"></textarea>
										<? } else{ ?>
											<span class="answer_title"><?=$answer["title"]?></span>
										<? } ?>

										<div class="cboth"></div>
									</div>
								<? } ?>
							<? } else{ ?>
								<textarea class="textbox" data-question-type="text" data-question-id="<?=$question["id"]?>" data-block-id="<?=$block["id"]?>"></textarea>
							<? } ?>

						</div>

					<? } ?>
				</div>

			<? } ?>

		</div>

		<div data-id="personal_info">
			<h2><?=t("Інші проблеми та пропозиції")?></h2>

			<textarea class="textbox" data-field-id="other_problem"></textarea>

			<table style="width: 100%" class="mt10">
				<tr>
					<td style="width: 115px" class="taright pr10">
						<?=t("Ім'я")?>
					</td>
					<td>
						<input type="text" class="textbox" data-field-id="fname">
					</td>
					<td style="width: 115px" class="taright pr10">
						<?=t("Прізвище")?>
					</td>
					<td>
						<input type="text" class="textbox" data-field-id="lname">
					</td>
				</tr>
				<tr>
					<td style="width: 115px" class="taright pr10">
						<?=t("Телефон")?>
					</td>
					<td>
						<input type="text" class="textbox" data-field-id="phone">
					</td>
					<td style="width: 115px" class="taright pr10">
						<?=t("Email")?>
					</td>
					<td>
						<input type="text" class="textbox" data-field-id="email">
					</td>
				</tr>
				<tr>
					<td style="width: 115px" class="taright pr10">
						<?=t("Адреса")?>
					</td>
					<td colspan="3">
						<input type="text" class="textbox" data-field-id="address">
					</td>
				</tr>
			</table>

			<a data-action="send" href="javascript:void(0);" class="v-button button-yellow">
				<i class="icon icon-plus-sign"></i>
				<?=t("Відправити відповіді")?>
			</a>
			<div class="cboth"></div>
		</div>

		<div>
			<div data-role="notices">
				<div data-notice-type="success" data-notice-id="form.sended">
					<p>
						<?=t("Вітаємо")?> :
						<span><?=t("Анкета успішно відправлена")?></span>
					</p>
					<div class="cboth"></div>
				</div>

				<div data-notice-type="error" data-notice-id="form.missed_question">
					<p>
						<?=t("Помилка")?> :
						<span><?=t("Ви відповіли не на всі питання")?></span>
					</p>
					<div class="cboth"></div>
				</div>

				<div data-notice-type="error" data-notice-id="form.missed_question">
					<p>
						<?=t("Помилка")?> :
						<span><?=t("Ви відповіли не на всі питання")?></span>
					</p>
					<div class="cboth"></div>
				</div>
			</div>
		</div>

	</div>
<?} ?>
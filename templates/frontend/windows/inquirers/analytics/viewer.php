<div ui-window="inquirers.analytics.viewer" style="width: 700px">

	<div class="fright">
		<a class="closeButton"></a>
	</div>

	<div>
		<h2><?=t("Дані прихильника")?></h2>
	</div>

	<div data-section="supporter" class="mt10">
		<div>
			<div class="mt15">
				<table id="profile_info" style="width: 100%;">
					<tr data-key="name" class="dnone"></tr>
					<tr data-key="geo" class="dnone"></tr>
					<tr data-key="address" class="dnone"></tr>
					<tr data-key="phone" class="dnone"></tr>
					<tr data-key="email" class="dnone"></tr>

					<tr><td colspan="2"><hr /></td></tr>

					<tr data-key="status" class="dnone reserved">
						<td class="title">
							<?=t("Статус прихильника")?>
						</td>
					</tr>
					<tr data-key="type" class="dnone reserved">
						<td class="title">
							<?=t("Тип")?>
						</td>
					</tr>
				</table>
			</div>
			<div class="cboth"></div>

		</div>
	</div>

	<div class="mt15">
		<h2><?=t("Відповіді на анкету")?></h2>
	</div>

	<div data-section="form" class="mt10">
		<div>
			<div class="mt15" data-id="form">

			</div>

			<div class="mt30 taright">
				<a data-action="close" href="javascript:void(0);" class="v-button button-yellow mr10">
					<?=t("Вихід")?>
				</a>
			</div>
			<div class="cboth"></div>

		</div>
	</div>

</div>
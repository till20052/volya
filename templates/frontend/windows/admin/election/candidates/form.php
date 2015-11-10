<div ui-window="admin.election.candidates.form" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Редагування")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<form action="/admin/election/j_save_candidate" method="POST">
			<div data-uiTabStrip>
				<ul>
					<li class="k-state-active"><?=t("Основне")?></li>
					<li><?=t("Стат. блоки")?></li>
					<li><?=t("Конкуренти / Будуть люстровані")?></li>
					<li><?=t("Агітація")?></li>
					<li><?=t("Результати")?></li>
				</ul>

				<div style="padding: 15px">
					<? include "form/basic.php"; ?>
				</div>

				<div style="padding: 15px">
					<? include "form/static.php"; ?>
				</div>
				
				<div style="padding: 15px">
					<? include "form/opponents.php"; ?>
				</div>
				
				<div style="padding: 15px">
					<? include "form/agitation.php"; ?>
				</div>
				
				<div style="padding: 15px">
					<? include "form/results.php"; ?>
				</div>
				
			</div>
			
			<div class="mt15 tacenter">
				<a href="javascript:void(0);" data-action="submit" data-add="<?=t("Створити")?>" data-edit="<?=t("Зберегти")?>" class="v-button v-button-blue"></a><!--
				--><a href="javascript:void(0);" data-action="cancel" class="v-button ml5"><?=t("Відміна")?></a>
			</div>
			
		</form>
		
	</div>

</div>
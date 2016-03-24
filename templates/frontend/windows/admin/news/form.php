<div ui-window="admin.news.form" style="width: 900px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Редактор")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<form action="/admin/news/j_save_item" method="post">
			
			<div data-uiTabStrip>
				<ul>
					<li class="k-state-active"><?=t("Загальне")?></li>
					<li><?=t("Мета дані")?></li>
					<li><?=t("Вибори 2014")?></li>
				</ul>
				<div style="padding: 15px">
					<? include "form/basic.php" ?>
				</div>
				<div style="padding: 15px">
					<? include "form/meta_data.php" ?>
				</div>
				<div style="padding: 15px">
					<? include "form/election.php" ?>
				</div>
			</div>
			
			<div class="mt15 pb5 tacenter">
				<a data-action="submit" href="javascript:void(0);" class="v-button v-button-blue mr5"><?=t("Зберегти")?></a><!--
				--><a data-action="cancel" href="javascript:void(0);" class="v-button"><?=t("Відміна")?></a>
			</div>
			
		</form>
		
	</div>
	
</div>
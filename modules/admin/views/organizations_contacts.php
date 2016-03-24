<script id="data">(<?=json_encode(array(
	"table#list" => array(
		"columns" => array(
			array("title" => "ID", "width" => "5%"),
			array("title" => t("Інформація")),
			array("title" => t("Дії"), "width" => "15%"),
		),
		"dataSource" => array(
			"data" => $list,
			"schema" => array(
				"model" => array(
					"id" => "id"
				)
			)
		)
	)
))?>)</script>

<div class="header">
	<div>
		<div>
			
			<table width="100%" cellpadding="0" cellspacing="0">
				<td>
					<h1>
						<a href="/admin">Адмін панель</a> / <?=t(OrganizationsContactsAdminController::$modAText)?>
					</h1>
				</td>
				<td class="taright">
					<a href="javascript:void(0);" id="add" class="icon v-button v-button-blue">
						<i class="icon-circleadd"></i>
						<span><?=t("Створити")?></span>
					</a>
				</td>
			</table>
			
		</div>
	</div>
</div>

<div>
	
	<div>
		
		<div>
			<table id="list" width="100%">
				<script type="text/x-kendo-template">
					<div class="tacenter">#=id#</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="pl20" style="line-height:normal">
						<div class="fwbold">#=title#</div>
						<div class="fs12">
							#=lname# #=fname#
						</div>
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5 pl20">
						<div>
							<a href="javascript:void(0);" ui="edit" data-id="#=id#" class="icon">
								<i class="icon-pencil"></i>
								<span><?=t("Змінити")?></span>
							</a>
						</div>
						<div>
							<a href="javascript:void(0);" ui="remove" data-id="#=id#" class="icon">
								<i class="icon-remove"></i>
								<span><?=t("Видалити")?></span>
							</a>
						</div>
					</div>
				</script>
			</table>
		</div>
		
	</div>
	
	<? if($pager->getPages() > 1){ ?>
		<div style="margin-top:50px">
			
			<div class="paginator">

				<? $__current = $pager->getPage() ?>
				<? $__count = $pager->getPages() ?>

				<div>
					<a href="<? if($__current > 1){ ?>?page=<?=($__current - 1)?><? } else { ?>javascript:void(0)<? } ?>"
					   class="arrow<? if( ! ($__current > 1)){ ?> disabled<? } ?>">
						<i class="icon-chevron-left"></i>
					</a>
				</div>

				<div>
					<ul>
						<? $__length = $__count > 5 ? 5 : $__count ?>
						<? $__start = $__current - round($__length / 2) ?>	
						<? $__end = $__current + intval($__length / 2); ?>

						<? if($__start < 0){ ?>
							<? $__end += abs($__start) ?>
							<? $__start = 0 ?>
						<? } ?>

						<? if($__end > $__count){ ?>
							<? $__start -= ($__end - $__count) ?>
							<? $__end = $__count ?>
						<? } ?>

						<? if($__start >= 1){ ?>
							<li>
								<a href="?page=1">1</a>
							</li>
							<? if($__start > 1){ ?>
								<li>...</li>
							<? } ?>
						<? } ?>

						<? for($__i = $__start; $__i < $__end; $__i++){ ?>
							<li>
								<a href="?page=<?=($__i + 1)?>"<? if($__i + 1 == $__current){ ?> class="current"<? } ?>><?=($__i + 1)?></a>
							</li>
						<? } ?>

						<? if($__end <= $__count - 1){ ?>
							<? if($__end < $__count - 1){ ?>
								<li>...</li>
							<? } ?>
							<li>
								<a href="?page=<?=$__count?>"><?=$__count?></a>
							</li>
						<? } ?>
					</ul>
				</div>

				<div>
					<a href="<? if($__current < $__count){ ?>?page=<?=($__current + 1)?><? } else { ?>javascript:void(0)<? } ?>"
					   class="arrow<? if( ! ($__current < $__count)){ ?> disabled<? } ?>">
						<i class="icon-chevron-right"></i>
					</a>
				</div>

			</div>
			
		</div>
		<? } ?>
	
</div>
<script id="data">(<?=json_encode(array(
	"filter" => array_merge($filter, array(
		"rid" => null,
		"aid" => null,
		"cid" => null
	)),
	"regions" => $geo["regions"],
	"table#list" => array(
		"columns" => array(
			array("title" => "ID", "width" => "5%"),
			array("title" => "", "width" => "5%"),
			array("title" => t("Інформація")),
			array("title" => t("Статус"), "width" => "15%"),
			array("title" => t("Активний"), "width" => "10%"),
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
))?>);</script>

<div class="header">
	<div>
		<div>
			<h1>
				<a href="/admin">Адмін панель</a> / <?=t(UsersAdminController::$modAText)?>
			</h1>
		</div>
	</div>
</div>

<div>
	<div>
		
		<table width="100%" cellspacing="0" cellpadding="0">
			
			<td>
				<a href="javascript:void(0);" id="add" class="icon v-button v-button-blue">
					<i class="icon-circleadd"></i>
					<span><?=t("Створити")?></span>
				</a>
			</td>
			
			<td class="pl15">
				<a href="javascript:void(0);" data-ui="open_finder" class="icon v-button">
					<i class="icon-search"></i>
					<span><?=t("Пошук")?></span>
				</a>
			</td>
			
			<? if($showCleanFilterLink){ ?>
				<td class="pl15">
					<a href="/admin/users" class="icon">
						<i class="icon-remove"></i>
						<span style="white-space: nowrap"><?=t("Очистити фільтр")?></span>
					</a>
				</td>
			<? } ?>
			
			<td width="99%">&nbsp;</td>
			
			<td>
				<a href="javascript:void(0);" data-ui="open_email_templates" class="icon v-button">
					<i class="icon-emailalt"></i>
					<span style="white-space: nowrap"><?=t("Розіслати email")?></span>
				</a>
			</td>
			
		</table>
		
	</div>
</div>

<div class="mt15">
	
	<div>
		
		<div>
			<table id="list" width="100%">
				<script type="text/x-kendo-template">
					<div class="tacenter">#=id#</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">
						# if(is_verified == 1){ #
							<span class="fs16" style="color:green"><i class="icon-ok"></i></span>
						# } else if(all_fields_are_filled == 1){ #
							<span class="fs16" style="color:yellow"><i class="icon-ok"></i></span>
						# } #
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="pl20" style="line-height:normal">
						<div class="fwbold"><a href="/profile/#=id#">#=last_name# #=first_name# #=middle_name#</a></div>
						<div>
							<a href="mailto:#=login#">#=login#</a>
						</div>
						# if(is_artificial == 1){ #
							<div style="color:orange"><?=t("Зареєстрований штучно")?></div>
						# } #
						<div>
							#=created_at#
						</div>
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">#=(function(type){
						var __type = " - не встановлено";
						switch(parseInt(type)){
							case 1:
								__type = "<?=t("Підпиcник")?>";
								break;
							case 50:
								__type = "<?=t("Прихильник")?>";
								break;
							case 99:
								__type = "<?=t("Кандидат в Члени партії ВОЛЯ")?>";
								break;
							case 100:
								__type = "<?=t("Член партії ВОЛЯ")?>";
								break;
						}
						return __type;
					}(type))#</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="tacenter">
						<input type="checkbox" ui="is_active" data-id="#=id#"# if(is_active == 1){ # checked# } # />
					</div>
				</script>
				<script type="text/x-kendo-template">
					<div class="p5 pl20">
						<div>
							<a href="javascript:void(0);" ui="view" data-id="#=id#" class="icon">
								<i class="icon-search"></i>
								<span><?=t("Переглянути")?></span>
							</a>
						</div>
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
	
	<div class="mt15">
		<div>
			<?=t("Всього")?>: <?=$pager->getTotal()?>
		</div>
	</div>
	
	<? if($pager->getPages() > 1){ ?>
		<div style="margin-top:50px">
			
			<div class="paginator">

				<? $__current = $pager->getPage() ?>
				<? $__count = $pager->getPages() ?>
				
				<? parse_str(parse_url(Uri::getUrn(), PHP_URL_QUERY), $__query) ?>
				<? if( ! isset($__query["page"])){ $__query["page"] = ""; } ?>

				<div>
					<? $__query["page"] = $__current - 1 ?>
					<a href="<? if($__current > 1){ ?>?<?=http_build_query($__query)?><? } else { ?>javascript:void(0)<? } ?>"
					   class="arrow<? if( ! ($__current > 1)){ ?> disabled<? } ?>">
						<i class="icon-chevron-left"></i>
					</a>
				</div>

				<div>
					<ul>
						<? $__length = $__count > 9 ? 9 : $__count ?>
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
								<? $__query["page"] = 1 ?>
								<a href="?<?=http_build_query($__query)?>">1</a>
							</li>
							<? if($__start > 1){ ?>
								<li>...</li>
							<? } ?>
						<? } ?>

						<? for($__i = $__start; $__i < $__end; $__i++){ ?>
							<li>
								<? $__query["page"] = $__i + 1 ?>
								<a href="?<?=http_build_query($__query)?>"<? if($__i + 1 == $__current){ ?> class="current"<? } ?>><?=($__i + 1)?></a>
							</li>
						<? } ?>

						<? if($__end <= $__count - 1){ ?>
							<? if($__end < $__count - 1){ ?>
								<li>...</li>
							<? } ?>
							<li>
								<? $__query["page"] = $__count ?>
								<a href="?<?=http_build_query($__query)?>"><?=$__count?></a>
							</li>
						<? } ?>
					</ul>
				</div>

				<div>
					<? $__query["page"] = $__current + 1 ?>
					<a href="<? if($__current < $__count){ ?>?<?=http_build_query($__query)?><? } else { ?>javascript:void(0)<? } ?>"
					   class="arrow<? if( ! ($__current < $__count)){ ?> disabled<? } ?>">
						<i class="icon-chevron-right"></i>
					</a>
				</div>

			</div>
			
		</div>
		<? } ?>
	
</div>
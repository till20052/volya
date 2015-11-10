<script id="data">(<?=json_encode(array(
	"table#list" => array(
		"columns" => array(
			array("title" => "ID", "width" => "5%"),
			array("title" => t("Інформація")),
			array("title" => t("К-ть отримувачів"), "width" => "15%"),
			array("title" => t("Статус"), "width" => "10%"),
		),
		"dataSource" => array(
			"data" => $list,
			"schema" => array(
				"model" => array(
					"id" => "id"
				)
			)
		)
	),
	"table#contacts" => array(
		"columns" => array(
			array("title" => t("Контакт")),
			array("title" => t("Дії"), "width" => "10%"),
		),
		"dataSource" => array(
			"data" => $contacts,
			"schema" => array(
				"model" => array(
					"id" => "id"
				)
			)
		)
	),
	"table#contacts_selector_table" => array(
		"columns" => array(
			array("width" => "10%"),
			array("title" => t("Контакт")),
		)
	),
	"email_templates" => array(
		"dataValueField" => "id",
		"dataTextField" => "subject.".Router::getLang(),
		"dataSource" => array(
			"data" => $emailTemplates
		)
	),
	"table#recipients" => array(
		"columns" => array(
			array("title" => t("ID"), "width" => "10%"),
			array("title" => t("Email"))
		)
	)
))?>)</script>

<div class="header">
	<div>
		<div>
		
			<table width="100%" cellpadding="0" cellspacing="0">
				<td>
					<h1>
						<a href="/admin">Адмін панель</a> / <?=t(MailerAdminController::$modAText)?>
					</h1>
				</td>
				<td class="taright">
					<a href="javascript:void(0);" id="add" class="icon v-button v-button-blue">
						<i class="icon-circleadd"></i>
						<span><?=t("запланувати розсилку")?></span>
					</a>
					<a href="javascript:void(0);" id="add_contacts" class="icon v-button v-button-blue">
						<i class="icon-addfriend"></i>
						<span><?=t("Додати контакти")?></span>
					</a>
				</td>
			</table>
			
		</div>
	</div>
</div>

<div class="mt15">
	
	<div>
		
		<div>
			<table width="100%">
				<tr>
					<td width="65%" class="pr15 vatop">
						<table id="list">
							<script type="text/x-kendo-template">
								<div class="tacenter">#=id#</div>
							</script>
							<script type="text/x-kendo-template">
								<div class="p5 pl15" style="line-height:normal">
									<div>
										#=subject#
									</div>
									<div>
										#=created_at#
									</div>
								</div>
							</script>
							<script type="text/x-kendo-template">
								<div class="p5 tacenter">
									<div>
										#=recipients_count#
									</div>
								</div>
							</script>
							<script type="text/x-kendo-template">
								<div class="tacenter">
									# if(status == -2){ #
										<span class="fs16" style="color:red"><i class="icon-remove-circle"></i></span>
									# } else if(status == -1){ #
										<a href="javascript:void(0);" ui="send_error_recipients" ui-mailer-id="#=id#" style="color:red"><i class="icon-banuser fs16"></i></a>
									# } else if(status == 0){ #
										<span class="fs16" style="color:black"><i class="icon-loading-hourglass"></i></span>
									# } else if(status == 1){ #
										<span class="fs16" style="color:orange"><i class="icon-syncalt"></i></span>
									# } else if(status == 2){ #
										<span class="fs16" style="color:green"><i class="icon-ok"></i></span>
									# } #
								</div>
							</script>
						</table>
					</td>
					
					<td>
						<table id="contacts">
							<script type="text/x-kendo-template">
								<div class="pl10">#=value#</div>
							</script>
							<script type="text/x-kendo-template">
								<div class="tacenter">
									<a href="javascript:void(0);" ui="remove" data-id="#=id#" class="icon">
										<i class="icon-remove" style="padding:0"></i>
									</a>
								</div>
							</script>
						</table>
					</td>
				</tr>
			</table>
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
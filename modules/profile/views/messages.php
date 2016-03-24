<div class="header">
	<div style="padding:15px 0">
		
		<div>
			<table width="100%">
				<td>
					<h1 class="ttuppercase"><?=t("Діалоги")?></h1>
				</td>
				<td width="300px" class="taright">
					<a href="javascript:void(0);" id="create_message" class="v-button v-button-yellow tacenter"><i class="icon-pencil"></i><?=t("Написати")?></a>
				</td>
			</table>
		</div>
		
	</div>
</div>

<div>
	
	<div>
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					
					<td valign="top">
						
						<div ui-frame="conversations">

							<div>
								<table width="100%" cellspacing="0" cellpadding="0" data-count="<?=$countConversations?>">

									<tbody>

										<? include "messages/conversations_rows.php"; ?>

									</tbody>

								</table>
							</div>

							<? if($countConversations > count($conversations)) { ?>
								<div class="mt30 tacenter">
									<a href="javascript:void(0);" id="show_more" class="v-button v-button-yellow"><?=t("Показати ще")?></a>
								</div>
							<? } ?>

						</div>
						
						<div ui-frame="messages" class="dnone">
							
							<div class="header">
								<table cellspacing="0" cellpadding="0">
									<td>
										<a href="javascript:void(0);" id="back"><i class="icon-chevron-left"></i></a>
									</td>
									<td>
										<h3 id="subject">Test</h3>
									</td>
								</table>
							</div>
							
							<div class="content">
								<table id="list" cellspacing="0" cellpadding="0">

									<tbody></tbody>

								</table>
							</div>
							
							<div class="navi">
								<table cellspacing="0" cellpadding="0">
									<td>
										<!-- START AVATAR -->
										<div class="avatar avatar-2x"<? if(UserClass::i()->getAvatar() != ""){ ?> style="background-image:url('/s/img/thumb/ai/<?=UserClass::i()->getAvatar()?>')"<? } ?>>
											<? if(UserClass::i()->getAvatar() == ""){ ?>
												<i class="icon-user"></i>
											<? } ?>
										</div>
										<!-- END AVATAR -->
									</td>
									<td>
										<textarea id="message" class="k-textbox" style="width:100%;height:100px;resize:vertical"></textarea>
									</td>
									<td>
										<input type="button" id="send_message" value="<?=t("Відповісти")?>" class="k-button" />
									</td>
								</table>
							</div>
							
						</div>
						
					</td>
					
					<td width="300px" valign="top" class="pl30">
						
						<? include "common/left.php"; ?>
						
					</td>
				
				</tr>
				
			</tbody>
			
		</table>
		
	</div>
	
</div>
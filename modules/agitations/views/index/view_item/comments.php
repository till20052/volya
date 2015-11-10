<div ui-box="comments" data-cid="<?=$indexNewsController->item["id"]?>">
	
	<div class="mb30">
		<h1 class="ttuppercase"><?=t("Коментарі")?></h1>
	</div>
	
	<div ui="form">
		<form action="/news/j_add_comment" method="POST" data-aid="<?=UserClass::i()->getId()?>">
			<div<? if(UserClass::i()->isAuthorized()){ ?> class="dnone"<? } ?>>
				<input type="text" id="name" data-label="<?=t("Ваше Ім'я")?>:" data-required="<? if(UserClass::i()->isAuthorized()){ ?>0<? } else { ?>1<? } ?>" class="k-textbox" style="width: 100%" />
			</div>
			
			<div class="mt20<? if(UserClass::i()->isAuthorized()){ ?> dnone<? } ?>">
				<input type="text" id="email" data-label="<?=t("E-mail")?>:"  data-required="<? if(UserClass::i()->isAuthorized()){ ?>0<? } else { ?>1<? } ?>" class="k-textbox" style="width: 100%" />
			</div>
			
			<div<? if( ! UserClass::i()->isAuthorized()){ ?> class="mt20"<? } ?>>
				<textarea id="text" data-label="<?=t("Ваш коментар")?>:" data-required="1" class="k-textbox" style="width: 100%; height: 130px; resize: vertical"></textarea>
			</div>
			
			<div class="mt20">
				<input type="submit" value="<?=t("Додати коментар")?>" class="k-button" />
			</div>
		</form>
	</div>
	
	<div ui="tree" class="mt30">
		<template>
			<div class="mb25">
				<div class="dtable" style="width: 100%">
					<div class="dtable-cell" style="width: 35px">
						<div class="avatar" style="background-image: url('/img/user_ico.png')"></div>
					</div>
					<div class="dtable-cell pl15" style="vertical-align: middle">
						<span class="name">#=item.author.name#</span><span class="date">#=item.date#</span>
					</div>
					<div class="dtable-cell" style="vertical-align: middle; width: 70px">
						<input type="button" ui="reply" value="<?=t("Відповісти")?>" class="k-button" style="width: 100%" />
					</div>
				</div>
				<div class="mt10" style="padding-left: 50px">#=item.text#</div>
			</div>
		</template>
		<data><?=json_encode($indexNewsController->item["comments"])?></data>
	</div>

</div>
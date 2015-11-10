<? $__files = $files[11]; ?>

<? $__group = PMGroupsModel::i()->getItem(11); ?>

<div class="section mt30">

	<div data-ui="materials">

		<div>
			<section>
				<ul>
					<? foreach($__files as $__file){ ?>
						<li>
							<div class="pic">
								<div class="icon">
									<i class="icon-file"></i>
								</div>
							</div>
							<div class="name">
								<a href="/s/storage/<?=$__file["hash"]?>" target="_blank"><?=$__file["name"]?></a>
							</div>
						</li>
					<? } ?>
					<li></li>
				</ul>
			</section>
		</div>

	</div>
</div>
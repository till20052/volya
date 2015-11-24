<div data-id="structure_header" class="header" style="margin-bottom: 0">
	<div class="breadcrumbs">

		<div>

			<h3>
				<a href="/structures"><?=t("Осередки")?></a>
				<? if(isset($filter["geo"])){ ?>
					/ <?=$filter["geo"]["location"]?>
				<? }elseif(isset($structure)){?>
					/ <?=$structure["title"]?>
				<?}?>
			</h3>

		</div>
	</div>
</div>